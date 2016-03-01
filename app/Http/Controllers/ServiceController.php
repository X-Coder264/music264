<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
        //usluga, studio, rejting, cijena, opis?!
        $services = DB::table('service_user')
                    ->join('services', 'service_user.service_id', '=', 'services.id')
                    ->join('users', 'service_user.user_id', '=', 'users.id')
                    ->where('service_user.approved', '=', 1)
                    ->where('services.slug', '=', $slug)
                    ->select('services.service','service_user.price','service_user.currency','service_user.description','users.name','users.slug')
                    ->get();

        return view('services.service', compact('services'));

    }
}
