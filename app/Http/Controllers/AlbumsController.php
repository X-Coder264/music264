<?php

namespace Artsenal\Http\Controllers;

use Artsenal\Http\Requests;
use Artsenal\Album;
use Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Artsenal\User;
use Session;
use Illuminate\Support\Facades\File;


class AlbumsController extends Controller{

    public function getList($slug)
    {

       // $user = User::findBySlug($slug);
        $user = User::findBySlug($slug);//->with('Album')->get();
        //$albums = Album::with('Photos')->get();

        return view('gallery.album', ['user' => $user]);
    }


    public function getAlbum($slug, $slugAlbum)
    {
        //$album = Album::with('Photos')->where('slugAlbum', '=', $slugAlbum)->get();
        $album = Album::findBySlug($slugAlbum);
        $user = User::findBySlug($slug);

        return view('gallery.album-show', ['user' => $user, 'album' => $album]);
    }


    public function getForm($slug)
    {
        $user = User::findBySlug($slug);
        return view('gallery.create-album', ['user' => $user]);

    }


    public function postCreate($slug)
    {
        $user = User::findBySlug($slug);

        $rules = array(

            'name' => 'required|unique:albums',
            'cover_image'=>'required|image',
            //'user_id' => 'in:int',

        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){

            return Redirect::route('create_album_form',$slug)->withErrors($validator)->withInput();
        }

        $file = Input::file('cover_image');
        $random_name = str_random(8);

        $extension = $file->getClientOriginalExtension();
        $filename=$random_name.'_cover.'.$extension;

        $album = Album::create(array(
            'name' => Input::get('name'),
            'user_id' =>  \Auth::user()->id,
            'description' => Input::get('description'),
            'cover_image' => $filename,
        ));
        $destinationPath = 'users/'. $user->slug.'/albums/'.$album->slugAlbum.'/';
        $uploadSuccess = Input::file('cover_image')->move($destinationPath, $filename);

        return Redirect::route('show_album', ['user' => $user->slug, 'idAlbum' => $album->slugAlbum]);
    }


    public function getDelete($slug, $slugAlbum)
    {
        $album = Album::findBySlug($slugAlbum);
        $user = User::findBySlug($slug);
        $path = 'users/'. $user->slug.'/albums/'.$album->slugAlbum;


        if (!File::deleteDirectory($path))
        {
            Session::flash('flash_message', 'ERROR deleted the File!');
            return Redirect::route('profile', [$user->slug]);
        }
        else
        {
            $album->delete();
            Session::flash('flash_message', 'Successfully deleted the File!');
            return Redirect::route('profile', [$user->slug]);
        }
    }
}