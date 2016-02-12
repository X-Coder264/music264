<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;

use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;
use Artsenal\Rating;
use Artsenal\User;
use DB;

class RatingsSongsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //dd($request);
        $value = $request->get('rate');
        //dd($test);

        Rating::create(array(
            'song_id' => $request->get('songId'),
            'user_id' => \Auth::user()->id,
            'value' => $value
        ));

        return $value;
    }

    public function ratingsValue()
    {
        $rating = DB::table('ratings')->where('user_id', '=', \Auth::user()->id)->get();

        return $rating;
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
}
