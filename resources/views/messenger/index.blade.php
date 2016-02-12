@extends('layout')

@section('content')

        <button type="button" class="btn btn-primary btn-lg btn-block">All your messages</button>

        <br><br>

        @if (Session::has('error_message'))
            <div class="alert alert-danger" role="alert">
                {!! Session::get('error_message') !!}
            </div>
        @endif

            <br>

        @if($threads->count() > 0)
            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                <tr>
                <th>Thread name</th>
                <th>Last message</th>
                <th>Creator</th>
                <th>Participants</th>
                </tr>
                </thead>
                <tbody>
            @foreach($threads as $thread)
                <?php $style = $thread->isUnread($currentUserId) ? 'background-color:#D9EDF7;' : ''; ?>
                    <tr style="{!!$style!!}">
                        <td><h4 class="media-heading">{!! link_to('messages/' . $thread->id, $thread->subject) !!}</h4></td>
                        <td><p>{!! $thread->latestMessage->body !!}</p></td>
                        <td><p>{!! $thread->creator()->name !!}</p></td>
                        <td><p>{!! $thread->participantsString(Auth::id()) !!}</p></td>
                    </tr>
            @endforeach
                </tbody>
            </table>
            {!! $threads->render() !!}
        @else
            <p>Sorry, no threads.</p>
        @endif

        <br>
        <hr>

        <a class="btn btn-warning btn-lg btn-block" href="{{URL::to('messages/create')}}">Create new message</a>
@stop
