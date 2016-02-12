<?php

namespace Artsenal\Http\Controllers\Auth;


use Artsenal\User;
use Artsenal\AuthenticateUser;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Artsenal\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'accType' => 'required|integer',
            'busType' => 'sometimes|integer',
            'dateOfBirth' => 'sometimes|date',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password'], array('rounds'=>15));
        if(array_key_exists('dateOfBirth', $data)) {
            $user->date_of_birth = Carbon::createFromFormat('d.m.Y', $data['dateOfBirth']);
        }
        if(array_key_exists('sex', $data)) {
            $user->sex = $data['sex'];
        }
        if(array_key_exists('description', $data)) {
            $user->description = $data['description'];
        }
        $user->location = $data['location'];


        $user->save();

        if ($data['accType'] == "0") {
            $user->attachRole(1);
        } else if ($data['accType'] == "1") {
            if ($data['busType'] == "0") {
                $user->attachRole(2);
                //take only what you need
            } else if ($data['busType'] == "1") {
                $user->attachRole(3);
            } else if ($data['busType'] == "2") {
                $user->attachRole(4);
            } else {
                //error
            }
        }
        else {
            //error
        }

        // TODO: napisati kod za unosenje usluga koje studio nudi prilikom registracije u bazu


        if(array_key_exists('genre', $data)) {
            foreach ($data['genre'] as $genreId) {
                DB::table('genre_user')->insert(['genre_id' => $genreId, 'user_id' => $user->id]);
            }
        }

        return $user;
    }

    public function SocialLogin(AuthenticateUser $authenticateUser, Request $request, $provider = null) {
        return $authenticateUser->execute($request->all(), $this, $provider);
    }

    public function userHasLoggedIn($user) {
      //  \Session::flash('message', 'Welcome, ' . $user->username);
        return redirect('/');
    }


    public function displayForm()
    {
        $genres = \Artsenal\Genre::all();
        return view('auth/register', ['genres' => $genres]);
    }
}
