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

        $value = $request->get('rate');
        $songId = $request->get('songId');


        //TODO:pametnije napravit funkciju u bazi nego ovdje se zafrkavat...
        $rating = DB::select('select * from ratings where user_id = ? and song_id = ?', array(\Auth::user()->id, $songId));
        //$rating = DB::table('ratings')->where('user_id', '=', \Auth::user()->id, 'AND', 'song_id', '=', $songId)->get();

        if ($rating==NULL){
            Rating::create(array(
                'song_id' => $request->get('songId'),
                'user_id' => \Auth::user()->id,
                'value' => $value
            ));
        }
        else
        {
            DB::update('update ratings set value = ? where user_id = ? and song_id = ?', array($value,\Auth::user()->id, $songId));
        }

        return $value;
    }

    public function ratingsValue(Request $request)
    {
        $songId = $request->get('songId');
        $rating = DB::select('select * from ratings where user_id = ? and song_id = ?', array(\Auth::user()->id, $songId));

        return $rating;
    }

    public function songInfo(Request $request)
    {
        $source = $request->get('source');
        $source=urldecode($source);

        $control=0;
        $song = '';
        //TODO:this if could cause problems maybe, check it later
        for ($i=10; $i<strlen($source);$i++){
            if ($source[$i-6]=='s' && $source[$i-5]=='o' && $source[$i-4]=='n' && $source[$i-3]=='g' && $source[$i-2]=='s' && $source[$i-1]=='/'){
                $control=1;
            }

            if ($control)
                $song = $song.$source[$i];
        }

        $song = DB::table('songs')->where('song', '=', $song)->get();

        return $song;
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
