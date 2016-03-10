<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = DB::table('services')
                    ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
                    ->select('services.slug', 'services.service', 'service_categories.category')
                    ->get();
        return view('services.services', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function serviceIndex($slug)
    {
        $services = DB::table('service_user')
                    ->join('services', 'service_user.service_id', '=', 'services.id')
                    ->join('users', 'service_user.user_id', '=', 'users.id')
                    ->where('service_user.approved', '=', 1)
                    ->where('services.slug', '=', $slug)
                    ->select('services.service','service_user.price','service_user.currency','service_user.description','service_user.service_id', 'service_user.user_id', 'users.name','users.slug')
                    ->get();

        $ratedServices = DB::table('service_ratings')
                        ->join('paypal_transactions', 'service_ratings.transaction_id', '=', 'paypal_transactions.transaction_id')
                        ->join('services', 'paypal_transactions.service_id', '=', 'services.id')
                        ->join('users', 'paypal_transactions.payer_user_id', '=', 'users.id')
                        ->whereNotNull('service_ratings.value')
                        ->whereNotNull('service_ratings.comment')
                        ->orderBy('service_ratings.time', 'desc')
                        ->select('service_ratings.value', 'service_ratings.comment', 'service_ratings.time', 'users.name', 'users.slug', 'paypal_transactions.payee_user_id', 'paypal_transactions.service_id')
                        ->get();

        $i = 0;
        foreach($ratedServices as $ratedService)
        {
            foreach($services as $service)
            {
                if($ratedService->service_id == $service->service_id && $ratedService->payee_user_id == $service->user_id)
                {
                    $service->arrayofRatings[$i]['value'] = $ratedService->value;
                    $service->arrayofRatings[$i]['comment'] = $ratedService->comment;
                    $service->arrayofRatings[$i]['time'] = $ratedService->time;
                    $service->arrayofRatings[$i]['commUser'] = $ratedService->name;
                    $service->arrayofRatings[$i]['commUserSlug'] = $ratedService->slug;
                    end($service->arrayofRatings);
                    $last_index=key($service->arrayofRatings);
                    $i = $last_index + 1;
                }
            }
        }

        return view('services.service', compact('services'));

    }

    public function serviceRateIndex($id)
    {
        $transaction = DB::table('paypal_transactions')
                        ->where('transaction_id', '=', $id)
                        ->select('transaction_id','payer_user_id')
                        ->get();

        $check = DB::table('service_ratings')
                ->where('transaction_id', '=', $id)
                ->whereNotNull('value')
                ->whereNotNull('comment')
                ->get();

        return view('services.comment', ['transaction' => $transaction, 'check' => $check]);
    }

    public function serviceRate(Request $request, $id)
    {
        if ($request->has('comment') && $request->has('rate')){
            DB::table('service_ratings')->where('transaction_id', '=', $id)->update([
                'comment' => $request->get('comment'),
                'value' => $request->get('rate'),
                'time' => Carbon::now()
            ]);

            return redirect()->route('profile', [\Auth::user()->slug])->with('status', 'Thank you for commenting!');
        }
    }
}
