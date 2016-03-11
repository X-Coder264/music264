<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;

use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;
use Artsenal\User;
use DB;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status=[];

        if (\Auth::user()) {
        $status = DB::table('status')
            ->join('followers', 'status.user_id', '=', 'followers.user_id')
            ->select('status.user_id', 'status.text', 'status.created_at', 'status.updated_at')
            ->where('follower_id', \Auth::user()->id)
            ->orderBy('status.updated_at', 'desc')
            ->get();

            $users = DB::table('users')
                ->join('followers', 'users.id', '=', 'followers.user_id')
                ->select('users.id', 'name', 'image_path')
                ->where('follower_id', \Auth::user()->id)
                ->get();

}

        return view('index', compact('status', 'users'));
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
}
