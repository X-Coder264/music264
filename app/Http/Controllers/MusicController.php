<?php
namespace Artsenal\Http\Controllers;
use Request;
use Validator;
use Artsenal\Http\Requests;
use Artsenal\User;
use Artsenal\Song;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Session;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $user=User::findBySlug($slug);
        return view('music-albums.music', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $user=User::findBySlug($slug);
        return view('music-albums.add-song', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($slug)
    {
        $user=User::findBySlug($slug);

        $rules = array(
            'name' => 'required|unique:songs',
            'user_id' => 'required|numeric|exists:users,id',
            'song'=> 'required|mimes:mpga' //PHP verzija mora bit 5.5.7 provijeri se sa "php -S localhost:8000", nije 100 godina trebalo da skuzim al nek jede govna
        );                                 //zasto mpga a ne mp3 ... rijeci su suvišne koliko je ovo idiotno

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()){
            return Redirect::route('add_song', ['user' => $user->id])
                ->withErrors($validator)
                ->withInput();
        }

        $file = Request::file('song');
        $destinationPath = 'users/'. $user->slug.'/songs/';
        $filename= $user->id.$file->getClientOriginalName();
        $uploadSuccess = Input::file('song')->move($destinationPath, $filename);
        Song::create(array(
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'song' => $filename,
            'user_id'=> Input::get('user_id')
        ));
        return Redirect::route('profile', [$user->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
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
    public function destroy($slug, $slugSong)
    {
        $song = Song::findBySlug($slugSong);
        $filename = $song->song;
        $path = 'users/'. $slug.'/songs/';


        if (!File::delete($path.$filename))
        {
            Session::flash('flash_message', 'ERROR deleted the File!');
            return Redirect::route('profile',[$slug]);
        }
        else
        {
            $song->delete();
            Session::flash('flash_message', 'Successfully deleted the File!');
            return Redirect::route('profile',[$slug]);
        }
    }
}