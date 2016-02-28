@extends('layout')
@section('styles')
    <link href="/assets/css/custom.css" rel="stylesheet">
    @stop

@section('content')


        <br><br>

        @if (Session::has('error_message'))
            <div class="alert alert-danger" role="alert">
                {!! Session::get('error_message') !!}
            </div>
        @endif

            <br>

       @if($user->threads->count() > 0)
           <div class="container inbox">
               <a class="btn btn-info btn-lg" href="{{URL::to('messages/create')}}">Create new message</a>
            @foreach($user->threads as $thread)
                <?php $style = $thread->isUnread($currentUserId) ? 'bg-new;' : ''; ?>
                    <div class="message {!!$style!!}">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 content">
                            <a href="#" class="author">{!! $thread->creator()->name !!}</a>
                            <br>
                            {!! link_to('messages/' . $thread->id, $thread->subject, $attributes = array('class' => 'title')) !!}
                            <br>
                            <p class="message_text">
                                {!! $thread->latestMessage->body !!}
                            </p>
                            <p class="participants">Participants: {!! $thread->participantsString(Auth::id()) !!}</p>
                        </div>
                    </div>
                    </div>
            @endforeach
           </div>
      @else
           <p>Sorry, no threads.</p>
       @endif

        <br>
        <hr>
@stop
