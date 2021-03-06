<?php

namespace Artsenal\Http\Controllers\User;

use Artsenal\User;
use Artsenal\Status;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use Request;
use Artsenal\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Artsenal\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id User id
     * @return Response
     */

    public function show($slug){
        $user = User::findBySlug($slug);
        $services = $user->getAllServices($user->id);

        $UpcomingEvents = [];
        if($user->hasRole(['artist', 'Venue'])) {
            $UpcomingEvents = $user->getAllUpcomingEvents();
        }

        $PassedEvents = [];
        if($user->hasRole(['artist', 'Venue'])) {
            $PassedEvents = $user->getAllDoneEvents();
        }

        $status = Status::Where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();

        $userTransactions = DB::table('paypal_transactions')
                            ->join('service_ratings', 'paypal_transactions.transaction_id', '=', 'service_ratings.transaction_id')
                            ->where('payer_user_id', $user->id)
                            ->orderBy('transaction_time', 'asc')
                            ->get();

        $payeesNames = [];
        $ServiceNames = [];

        foreach($userTransactions as $userTransaction){
            $payeesNames[] = DB::table('users')->where('id', '=', $userTransaction->payee_user_id)->value('name');
            $ServiceNames[] = DB::table('services')->where('id', '=', $userTransaction->service_id)->value('service');
        }

        return view('user.profile', ['user' => $user, 'status' => $status, 'services' => $services, 'UpcomingEvents' => $UpcomingEvents, 'PassedEvents' => $PassedEvents, 'userTransactions' => $userTransactions, 'payeesNames' => $payeesNames, 'ServiceNames' => $ServiceNames]);
    }

    public function showProfileSettings() {
        $user = User::findOrFail(\Auth::user()->id);
        $services = DB::table('services')
                    ->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')
                    ->select('services.id', 'services.service', 'service_categories.category')
                    ->orderBy('service_categories.id', 'asc')
                    ->get();
        $checkedServicesID = DB::table('service_user')
                            ->where('user_id', \Auth::user()->id)
                            ->lists('service_id');
        $checkedServices = DB::table('service_user')
                            ->join('services','service_user.service_id' ,'=' ,'services.id')
                            ->where('user_id', \Auth::user()->id)
                            ->select('service_id', 'service', 'price', 'currency', 'description', 'approved')
                            ->get();
        return view('user.settings', ['user' => $user, 'services' => $services, 'checkedServicesID' => $checkedServicesID, 'checkedServices' => $checkedServices]);
    }

    public function showStatus($slug){
        $user = User::findBySlug($slug);
        $status = Status::Where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
        return $status;
    }

    public function storeStatus($slug)
    {
        $input = Request::all();

        $status = new Status();
        $status->text = $input['text'];

        $user = User::findBySlug($slug);

        $status->user_id = $user->id;
        $status->created_at = Carbon::now();
        $status->save();

        $status2 = [];
        $status2['text'] = $status->text;
        $status2['created_at'] = $status->created_at->diffForHumans();

        return $status2;
    }

    public function follow($userSlug){
        $user = User::findBySlug($userSlug);
        $input = Request::all();
        $follower_id = $input['id'];
        $All_Followers_Of_The_User = DB::table('followers')->where('user_id', $user->id)->lists('follower_id');
        if(in_array($follower_id, $All_Followers_Of_The_User)){
            DB::table('followers')->where('user_id', $user->id)->where('follower_id', \Auth::user()->id)->delete();
            return Redirect::back()->with('message','You have succesfully unfollowed this user!');
        }
        else{
            DB::table('followers')->insert(
                ['user_id' => $user->id, 'follower_id' => \Auth::user()->id]
            );
            return Redirect::back()->with('message','You have succesfully started following this user!');
        }
    }

    public function postUpdateData(Requests\UserUpdateRequest $request) {

        $user = User::findOrFail(\Auth::user()->id);

        $profilePicture = $request->file('image');
        if ($profilePicture != null) {
            $destinationPath = 'imgs/'; // upload path
            $thumbnailPath = 'imgs/thumbnails/'; // upload path
            $extension = $profilePicture->getClientOriginalExtension(); // getting image extension
            $fileName = 'profile_' . $user->id . '.' . $extension; // renameing image
            $profilePicture->move($destinationPath, $fileName);
            $user->image_path = $destinationPath . $fileName;
        }

        $user->description = $request->get('description');
        $user->location = $request->get('location');
        $user->save();

        $NewServices = $request->get('services');

        //if the user sends what services he currently provides update the database accordingly
        if($NewServices != null){
            $OldServices = $user->getAllServices($user->id);
            $OldServicesID = array();
            foreach($OldServices as $oldService){
                $OldServicesID[] = $oldService->service_id;
            }

            //if the checked services don't exist in the database then insert them
            foreach($NewServices as $newService){
                if(!in_array($newService, $OldServicesID)){
                    DB::table('service_user')->insert([
                        ['service_id' => $newService, 'user_id' => $user->id, 'created_at' => Carbon::now()]
                    ]);
                }
            }

            //if there are services in the database that the user no longer provides then delete them
            foreach($OldServicesID as $OldServiceID){
                if(!in_array($OldServiceID, $NewServices)){
                    DB::table('service_user')->where('service_id', $OldServiceID)->where('user_id', $user->id)->delete();
                }
            }

        }
        // if the user doesn't provide any service
        else{
            DB::table('service_user')->where('user_id', $user->id)->delete();
        }

        if ($request->has('id') && $request->has('price') && $request->has('currency') && $request->has('service_description')) {

            $ServiceIds = $request->get('id');
            $ServicePrices = $request->get('price');
            $ServiceCurrencies = $request->get('currency');
            $ServiceDescriptions = $request->get('service_description');

            $i = 0;
            foreach($ServiceIds as $currentServiceId){
                DB::table('service_user')->where('service_id', $currentServiceId)
                                         ->where('user_id', \Auth::user()->id)
                                         ->update([
                                             'price' => $ServicePrices[$i],
                                             'currency' => $ServiceCurrencies[$i],
                                             'description' => $ServiceDescriptions[$i],
                                             'updated_at' => Carbon::now()
                                         ]);
                $i++;
            }
        }

        return Redirect::back();
    }

    public function updateImage() {
        var_dump('kjdnsfk');
    }

}
