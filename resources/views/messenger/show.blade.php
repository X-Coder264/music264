@extends('layout')

@section('content')
    <div class="col-md-6">
        <h1>{!! $thread->subject !!}</h1>

        <div>Participants:
        @foreach($users as $user)
                {{ $user->name }}
        @endforeach
        </div>
        @foreach($thread->messages as $message)
            <div class="media">
                <a class="pull-left" href="#">
                    <img src="//www.gravatar.com/avatar/{!! md5($message->user->email) !!}?s=64" alt="{!! $message->user->name !!}" class="img-circle">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">{!! $message->user->name !!}</h5>
                    @if($message->user->hasRole('Service Provider'))
                    <p style = "background-color: yellow;">{!! $message->body !!}</p>
                        @elseif($message->user->hasRole('artist'))
                        <p style = "background-color: red;">{!! $message->body !!}</p>
                        @else
                        <p style = "background-color: lightgrey;">{!! $message->body !!}</p>
                    @endif
                    <div class="text-muted"><small>Posted {!! $message->created_at->diffForHumans() !!}</small></div>
                </div>
            </div>
        @endforeach

        <h2>Add a new message</h2>
        {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
        </div>

        {{--@if($users->count() > 0)
        <div class="checkbox">
            @foreach($users as $user)
                <label title="{!! $user->name !!}"><input type="checkbox" name="recipients[]" value="{!! $user->id !!}">{!! $user->name !!}</label>
            @endforeach
        </div>
        @endif --}}

        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-warning form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop
