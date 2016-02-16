<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('create-event');
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
        DB::table('events')->insert([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'time' => $request->time,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // TODO: Redirect back with a proper message
        return redirect('/');
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

    public function getVenues()
    {
        $venues = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 4)->lists('users.id', 'users.name');
        $venues2 = array();

        $i = 0;
        foreach($venues as $venue => $id){
            $venues2[$i]['value'] = $id;
            $venues2[$i]['text'] = $venue;
            $i++;
        }

        return json_encode($venues2);
    }

    public function getArtists()
    {
        $artists = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_user.role_id', 2)->lists('users.id', 'users.name');
        $artists2 = array();

        $i = 0;
        foreach($artists as $artist => $id){
            $artists2[$i]['value'] = $id;
            $artists2[$i]['text'] = $artist;
            $i++;
        }

        return json_encode($artists2);
    }
}
