@extends('layout')
@section('styles')
    <link href="/assets/css/custom.css" rel="stylesheet">
@stop
@section('content')
    <div class="inbox">
            <div class="message content bg-new">
                        <p class="author" style="font-weight: bold;">{{ $event->name }}</p>
                        <br>
                        <br>
                        <p class="message_text">
                            {{ $event->description }}
                        </p>
                        <p class="participants">{{$event->time}} ({{\Carbon\Carbon::parse($event->time)->diffForHumans()}})</p>
                </div>
        {!! Form::open(['route' => ['event_users', $event->slug]]) !!}

        @if(empty($check))
        <p>Will you come to this event? Please leave your status below.</p>
        @else
            <p>Would you like to change your status? Please do so below.</p>
        @endif
            <div class="form-group">
                <button type="submit" name="status" class="btn btn-primary form-control" value="1">I'll go to this event</button>
            </div>
            <div class="form-group">
                <button type="submit" name="status" class="btn btn-primary form-control" value="0">I'll maybe go to this event</button>
            </div>
        {!! Form::close() !!}
    </div>

    <div class="row">
        <div class="col-md-6">
            @if(!empty($GoingUsers))
                <p>Users who are coming to this event for sure:</p>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<count($GoingUsers); $i++)
                        <tr>
                            <td><a href="/profile/{{$GoingUsers[$i]->slug}}">{{$GoingUsers[$i]->name}}</a></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            @else
                <p>No one is coming for sure to this event at the moment.</p>
            @endif
        </div>
        <div class="col-md-6">
            @if(!empty($MaybeUsers))
                <p>Users who are not sure about coming to this event:</p>
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i=0; $i<count($MaybeUsers); $i++)
                        <tr>
                            <td><a href="/profile/{{$MaybeUsers[$i]->slug}}">{{$$MaybeUsers[$i]->name}}</a></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            @else
                <p>No one is unsure about coming to this event at the moment.</p>
            @endif
        </div>
    </div>

@stop