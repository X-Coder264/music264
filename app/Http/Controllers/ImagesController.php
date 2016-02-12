<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;

use Artsenal\Http\Requests;
use Artsenal\Images;
use Artsenal\Album;
use Artsenal\Http\Controllers\Controller;
//use app/Repositories/Images;
use Validator;
use Artsenal\User;
use Artsenal\Status;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Support\Facades\File;


class ImagesController extends Controller{

    public function getForm($slug, $slugAlbum)
    {
        $album = Album::findBySlug($slugAlbum);
        $user = User::findBySlug($slug);

        return view('gallery.add-image', ['user' => $user, 'album' => $album]);
    }

    public function postAdd($slug, $slugAlbum)
    {
        $user = User::findBySlug($slug);
        $album = Album::findBySlug($slugAlbum);

        $rules = array(

            'album_id' => 'required|numeric|exists:albums,id',
            'image'=>'required|image'

        );

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){

            //return Redirect::route('add_image',array('id' =>Input::get('album_id')))
            return Redirect::route('add_image', ['user' => $user->slug, 'albumSlug'=>Input::get('albumSlug')])
                ->withErrors($validator)
                ->withInput();
        }



        $file = Input::file('image');
        $destinationPath = 'users/'. $user->slug.'/albums/'.$album->slugAlbum.'/';
        $filename= $user->id.$file->getClientOriginalName();
        $uploadSuccess = Input::file('image')->move($destinationPath, $filename);
        Images::create(array(
            'description' => Input::get('description'),
            'image' => $filename,
            'album_id'=> Input::get('album_id')
        ));

        return Redirect::route('show_album', [$user->slug, $album->slugAlbum]);
    }


    public function getDelete($slug, $slugImage)
    {
        $image = Images::findBySlug($slugImage);
        $user = User::findBySlug($slug);
        $album = Album::findBySlugOrId($image->album_id);

        $filename = $image->image;
        $path = 'users/'. $user->slug.'/albums/'.$album->slugAlbum.'/';


        if (!File::delete($path.$filename))
        {
            Session::flash('flash_message', 'ERROR deleted the File!');
            return Redirect::route('show_album',[$user->slug, $image->album->slugAlbum ]);
        }
        else
        {
            $image->delete();
            Session::flash('flash_message', 'Successfully deleted the File!');
            return Redirect::route('show_album',[$user->slug, $image->album->slugAlbum ]);
        }
    }


   /* public function postMove($slug)
    {
        $user = User::findBySlug($slug);

        $rules = array(
            'new_album' => 'required|numeric|exists:albums,id',
            'photo'=>'required|numeric|exists:images,id'
        );
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){

            return Redirect::route('album', ['user' => $user]);
        }
        $image = Images::find(Input::get('photo'));
        $image->album_id = Input::get('new_album');
        $image->save();
        return Redirect::route('show_album', ['user' => $user, 'id'=>Input::get('new_album')]);
    }*/
}

