@extends('layout')

@section('content')
    <h1>Start a new conversation with {{$user[0]->name}}</h1>
    {!! Form::open(['route' => 'messages.store']) !!}
    <div class="col-md-6">

        {{--<div class="form-group">
            {!! Form::label('recipients', 'Name of the receiver', ['class' => 'control-label']) !!}
            <input type="text" name="recipients[]" class="form-control" id="recipients" value="{{$user[0]->id}}" required>
        </div> --}}

        <input type="hidden" name="recipients[]" class="form-control" id="recipients" value="{{$user[0]->id}}" required>

        <!-- Subject Form Input -->
        <div class="form-group">
            {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
            {!! Form::text('subject', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Message Form Input -->
        <div class="form-group">
            {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Submit Form Input -->
        <div class="form-group">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@stop
