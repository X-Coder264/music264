<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use Artsenal\Event;
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
        return view('events.create-event');
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
        if ($request->has('artist')) {
            Event::create([
                'artist_user_id' => $request->artist,
                'venue_user_id' => Auth::id(),
                'name' => $request->name,
                'description' => $request->description,
                'time' => $request->time,
            ]);
        }
        else{
            Event::create([
                'artist_user_id' => Auth::id(),
                'venue_user_id' => $request->venue,
                'name' => $request->name,
                'description' => $request->description,
                'time' => $request->time,
            ]);
        }

        // TODO: Redirect back with a proper message
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $event = Event::findBySlug($slug);

        $eventID = DB::table('events')->where('slug', '=', $slug)->value('id');
        $check = DB::table('event_users')
                    ->where('event_id', '=', $eventID)
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();

        $GoingUsers = DB::table('users')
                        ->join('event_users', 'users.id', '=', 'event_users.user_id')
                        ->where('event_id', '=', $eventID)
                        ->where('event_users.status', '=', 1)
                        ->select('users.name', 'users.slug')
                        ->get();

        $MaybeUsers = DB::table('users')
            ->join('event_users', 'users.id', '=', 'event_users.user_id')
            ->where('event_id', '=', $eventID)
            ->where('event_users.status', '=', 0)
            ->select('users.name', 'users.slug')
            ->get();

        return view('events.show-event', ['event' => $event, 'check' => $check, 'GoingUsers' => $GoingUsers, 'MaybeUsers' => $MaybeUsers]);
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

    public function userEventStatus(Request $request, $slug)
    {
        if($request->has('status') && is_numeric($request->get('status')))
        {
            $eventID = DB::table('events')->where('slug', '=', $slug)->value('id');
            $event = DB::table('event_users')->where('event_id', '=', $eventID)->where('user_id', '=', Auth::user()->id)->get();
            if(empty($event))
            {
                DB::table('event_users')->insert([
                    'user_id' => Auth::user()->id,
                    'event_id' => $eventID,
                    'status' => $request->get('status'),
                    'created_at' => Carbon::now()
                ]);
            }
            else
            {
                DB::table('event_users')->where('event_id', '=', $eventID)
                    ->where('user_id', '=', Auth::user()->id)
                    ->update([
                    'status' => $request->get('status'),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        // TODO: Redirect back with a proper message
        return redirect('/');
    }
}
