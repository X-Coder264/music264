<?php

namespace Artsenal\Http\Controllers\User;

use Artsenal\User;
use Artsenal\Status;
use DB;
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

        $events = [];
        if($user->hasRole(['artist', 'Venue'])) {
            $events = $user->getAllUpcomingEvents();
        }
        $status = Status::Where('user_id', '=', $user->id)->get();

        return view('user.profile', ['user' => $user, 'status' => $status, 'services' => $services, 'events' => $events]);
    }

    public function showProfileSettings() {
        $user = User::findOrFail(\Auth::user()->id);
        $services = DB::table('services')->join('service_categories', 'services.service_categories_id', '=', 'service_categories.id')->select('services.id', 'services.service', 'service_categories.category')->get();
        $checkedServicesID = DB::table('service_user')->where('user_id', \Auth::user()->id)->lists('service_id');
        $checkedServices = DB::table('service_user')->join('services','service_user.service_id' ,'=' ,'services.id')->where('user_id', \Auth::user()->id)->select('service_id', 'service', 'price', 'currency', 'description', 'approved')->get();
        return view('user.settings', ['user' => $user, 'services' => $services, 'checkedServicesID' => $checkedServicesID, 'checkedServices' => $checkedServices]);
    }

    public function showStatus(){
        $user = User::Where('id', \Auth::user()->id)->firstOrFail();
        $status = Status::Where('user_id', '=', $user->id)->get();
        return $status;
    }

    public function storeStatus()
    {
        $input = Request::all();

        $status = new Status();
        $status->text = $input['text'];

        $user_id = \Auth::user()->id;

        $status->user_id = $user_id;
        $status->created_at = \Carbon\Carbon::now();
        $status->save();

        return $status;
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
                        ['service_id' => $newService, 'user_id' => $user->id]
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
                                             'description' => $ServiceDescriptions[$i]
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
