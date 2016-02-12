{!! Form::open(array('route' => array('store_ratings_song', Auth::user()->slug))) !!}
{!!Form::hidden('user_id', Auth::user()->id) !!}

<div class="rating">

    {!! Form::radio('rate', '1', '',array('class' => 'rate-1')) !!}
    {!!Form::label('rate-1', '1', array('class' => 'rate-1'))!!}

    {!! Form::radio('rate', '2', '',array('class' => 'rate-2')) !!}
    {!!Form::label('rate-2', '2', array('class' => 'rate-2'))!!}

    {!! Form::radio('rate', '3', '',array('class' => 'rate-3')) !!}
    {!!Form::label('rate-3', '3', array('class' => 'rate-3'))!!}

    {!! Form::radio('rate', '4', '',array('class' => 'rate-4')) !!}
    {!!Form::label('rate-4', '4', array('class' => 'rate-4'))!!}

    {!! Form::radio('rate', '5', '',array('class' => 'rate-5')) !!}
    {!!Form::label('rate-5', '5', array('class' => 'rate-5'))!!}
    <span></span>
</div>
{!! Form::close() !!}





