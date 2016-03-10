<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\File;
use Artsenal\User;
use Carbon\Carbon;
use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

class PayPalController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function postPayment(Request $request)
    {
        $service_requested = $request->all();

        $service = DB::table('service_user')->join('services', 'service_id', '=', 'services.id')
            ->join('users', 'service_user.user_id', '=', 'users.id')
            ->where('service_user.service_id', $service_requested['service_id'])
            ->where('service_user.user_id', $service_requested['user_id'])
            ->select('service_user.*', 'services.service as service_name', 'users.name as user_name')
            ->get();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName($service[0]->service_name) // item name
        ->setCurrency($service[0]->currency)
            ->setQuantity(1)
            ->setPrice($service[0]->price); // unit price


        /*$item_2 = new Item();
        $item_2->setName('Item 2')
            ->setCurrency('USD')
            ->setQuantity(4)
            ->setPrice('70');*/


        // add item to list
        $item_list = new ItemList();
        //$item_list->setItems(array($item_1, $item_2));
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency($service[0]->currency)
            ->setTotal($service[0]->price);

        $description = $service[0]->service_name . ' - ' . $service[0]->user_name;

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($description);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status')) // Specify return URL
                      ->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                echo $ex->getCode(); // Prints the Error Code
                echo $ex->getData(); // Prints the detailed error message
                //echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                dd($err_data);
                exit();
            } else {
                die('Some error occured, sorry for the inconvenience.');
           }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID, service ID, and user ID to session
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('service_id', $service_requested['service_id']);
        Session::put('payee_user_id', $service_requested['user_id']);

        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }

        return redirect()->route('payment')
            ->with('message', 'Error.');
    }

    public function getPaymentStatus()
    {
        // Get the payment, service and user ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        $service_id = Session::get('service_id');
        $payee_user_id = Session::get('payee_user_id');

        // clear the session payment, service and user ID
        Session::forget('paypal_payment_id');
        Session::forget('service_id');
        Session::forget('payee_user_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return redirect()->route('payment')->with('message', 'Payment failed');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // payment made

            //get transaction details
            $data['transaction_id'] = $result->transactions[0]->related_resources[0]->sale->id;
            $data['transaction_time'] = Carbon::now();
            $data['transaction_currency'] = $result->transactions[0]->related_resources[0]->sale->amount->currency;
            $data['transaction_amount'] = $result->transactions[0]->related_resources[0]->sale->amount->total;

            //get payer details
            $data['payer_first_name'] = $result->payer->payer_info->first_name;
            $data['payer_last_name'] = $result->payer->payer_info->last_name;
            $data['payer_email'] = $result->payer->payer_info->email;

            $data['buyer_Artsenal_name'] = Auth::user()->name;
            $data['seller_Artsenal_name'] = DB::table('users')->where('id', '=', $payee_user_id)->value('name');
            $data['bought_service_name'] = DB::table('services')->where('id', '=', $service_id)->value('service');

            $pdf = \PDF::loadView('PPInvoice', compact('data'));

            $user_invoice_folder = public_path() . '/users/' . Auth::user()->slug . '/invoices/';

            if(!File::exists($user_invoice_folder)) {
                File::makeDirectory($user_invoice_folder, $mode = 0777, true, false);
            }

            $save_path = '/users/' . Auth::user()->slug . '/invoices/' . $data['transaction_time']->year . '-' . $data['transaction_time']->month . '-' . $data['transaction_time']->day . ' - invoice - ' . $data['transaction_id'] . '.pdf';

            $pdf->save(public_path() . $save_path);

            DB::table('paypal_transactions')->insert(
                ['payer_user_id' => Auth::user()->id,
                 'payer_first_name' => $data['payer_first_name'],
                 'payer_last_name' => $data['payer_last_name'],
                 'payer_email' => $data['payer_email'],
                 'service_id'  => $service_id,
                 'payee_user_id'  => $payee_user_id,
                 'transaction_id' => $data['transaction_id'],
                 'transaction_time' => $data['transaction_time'],
                 'transaction_amount' => $data['transaction_amount'],
                 'transaction_currency' => $data['transaction_currency'],
                 'invoice_path' => $save_path
                ]
            );

            DB::table('service_ratings')->insert(
                ['transaction_id' => $data['transaction_id'],
                    'value' => NULL,
                    'comment' => NULL
                ]
            );

            return redirect()->route('payment')->with('message', 'Payment successful')
                                               ->with('transaction_amount', $data['transaction_amount'])
                                               ->with('transaction_currency', $data['transaction_currency'])
                                               ->with('invoice_url', $save_path);
        }

        return Redirect::route('payment')
            ->with('message', 'Payment failed');
    }


}
