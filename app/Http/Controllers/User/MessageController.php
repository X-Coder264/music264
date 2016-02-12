<?php

namespace Artsenal\Http\Controllers\User;

use Artsenal\User;
use Response;
use Illuminate\Http\Request;
use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
{
    /**
     * Just for testing - the user should be logged in. In a real
     * app, please use standard authentication practices.
     */
    public function __construct()
    {
        //
    }
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $currentUserId = Auth::user()->id;
        $user = User::find($currentUserId)->with('threads', 'threads.messages', 'threads.participants', 'threads.messages.user')->first();
        return view('messenger.index', compact('user', 'currentUserId'));
    }
    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);
        return view('messenger.show', compact('thread', 'users'));
    }
    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        return view('messenger.create');
    }

    public function create2($slug)
    {
        $user = User::where('slug', $slug)->get();

        return view('messenger.create2', compact('user'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store()
    {
        $input = Input::all();

        $myString = $input['recipients'][0];
        $myArrayOfIDs = explode(',', $myString);

        $myArrayOfIDs2 = array();
        $i = 0;
        foreach($myArrayOfIDs as $arrayOfID){
            $myArrayOfIDs2[$i] = (int)$arrayOfID;
            $i++;
        }

        //TODO: provjera ispravnosti ID-a, implementirati feature gdje korisnik može odabrati da želi primati PM samo od staffa ili od usera koji ga npr followaju

        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'body'      => $input['message'],
            ]
        );
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        if (Input::has('recipients')) {
                $thread->addParticipants($myArrayOfIDs2);
        }
        return redirect('messages');
    }
    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => Input::get('message'),
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants(Input::get('recipients'));
        }
        return redirect('messages/' . $id);
    }

    public function getUsers(){
        $users = User::where('id', '!=', Auth::user()->id)->lists('id', 'name');
        $users2 = array();

        $i = 0;
        foreach($users as $user => $id){
            $users2[$i]['value'] = $id;
            $users2[$i]['text'] = $user;
            $i++;
        }

        return json_encode($users2);
    }
}
