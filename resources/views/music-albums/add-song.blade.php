@extends ('layout')

@section ('content')

        <!--
    <div class="form-group">
    </div>-->
<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:100px;">

        @include('error-notification')

        {!! Form::open(array('route' => array('store_song', Auth::user()->slug), 'files' => true)) !!}

            {!!Form::hidden('user_id', Auth::user()->id) !!}

            <div class="form-group">
                {!!Form::label('name', 'Song Name')!!}
                {!!Form::text('name', '', array('class'=>'form-control', 'placeholder'=>'Song name...')) !!}
            </div>

            <div class="form-group">
                {!!Form::label('description', 'Song Description')!!}
                {!!Form::textarea('description', '', array('class'=>'form-control', 'placeholder'=>'Song description...')) !!}
            </div>

            <div class="form-group">
                {!!Form::label('song', 'Select a song')!!}
                {!!Form::file('song')!!}
            </div>

            {!! Form::submit('Add!', array('class' => 'btn btn-default'))!!}

        {!! Form::close() !!}

    </div>
</div>







@endsection