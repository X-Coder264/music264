@extends ('layout')


@section ('content')


<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:100px;">

        @include('error-notification')

        <legend>Create an Album</legend>
        {!! Form::open(array('route' => array('createAlbum', Auth::user()->slug), 'files' => true)) !!}

            {!!Form::hidden('user_id', Auth::user()->id) !!}

            <div class="form-group">
                {!!Form::label('name', 'Album Name')!!}
                {!!Form::text('name', '', array('class'=>'form-control', 'placeholder'=>'Album Name...')) !!}
            </div>

            <div class="form-group">
                {!!Form::label('description', 'Album Description')!!}
                {!!Form::textarea('description', '', array('class'=>'form-control', 'placeholder'=>'Album description...')) !!}
            </div>

            <div class="form-group">
                {!!Form::label('cover_image', 'Select a Cover Image')!!}
                {!!Form::file('cover_image')!!}
            </div>

            {!! Form::submit('Create!', array('class' => 'btn btn-default'))!!}

        {!! Form::close() !!}

    </div>
</div> <!-- /container -->
@endsection