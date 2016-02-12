@extends ('layout')


@section ('content')

<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:100px;">

        @include('error-notification')

        <legend>Add an Image to {{$album->name}}</legend>

        {!! Form::open(array('route' => array('add_image_to_album', $user->slug, $album->slugAlbum), 'files' => true)) !!}

            {!!Form::hidden('album_id', $album->id) !!}

            <div class="form-group">
                {!!Form::label('description', 'Image Description')!!}
                {!!Form::textarea('description', '', array('class'=>'form-control', 'placeholder'=>'Image description...')) !!}
            </div>

            <div class="form-group">
                {!!Form::label('image', 'Select an Image')!!}
                {!!Form::file('image')!!}
            </div>

            {!! Form::submit('Add!', array('class' => 'btn btn-default'))!!}

        {!! Form::close() !!}
    </div>
</div> <!-- /container -->

@endsection

