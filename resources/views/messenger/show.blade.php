@extends('layout')
@section('styles')
    <link href="/assets/css/custom.css" rel="stylesheet">
@stop

@section('content')
    <div class="container inbox">
        <h1>{!! $thread->subject !!}</h1>

        <div>Participants:
        @foreach($users as $user)
                {{ $user->name }}
        @endforeach
        </div>
        @foreach($thread->messages as $message)
            <div class="message">
                <div class="row">
                    <img style="float:left; max-width: 130px;;"  src="//www.gravatar.com/avatar/{!! md5($message->user->email) !!}?s=64" alt="{!! $message->user->name !!}">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 content">
                        <a href="#" class="author">{!! $message->user->name !!}</a>
                        <br>
                        <p class="message_text">
                            {!! $message->body !!}
                        </p>
                        <a href="#" class="message_number">{!! $message->created_at->diffForHumans() !!}</a>
                    </div>
                </div>
            </div>

        @endforeach

        <div class="container">
            <div class="panel panel-default new_reply">
                <div class="panel-heading">
                    <h4>Add a new message</h4>
                </div>
                <div class="panel-body">
                    <!-- FORM -->
                    {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
                        <div class="form-group">
                            <textarea class="form-control" rows="6" id="reply"></textarea>
                        </div>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-orange']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
