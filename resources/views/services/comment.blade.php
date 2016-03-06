@extends('layout')
@section('content')
    @if(Auth::user()->id == $transaction[0]->payer_user_id)
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">Comment and rate the delivered service</div>
                    <div class="panel-body">

                        {!! Form::open(['route' => ['comment_service', $transaction[0]->transaction_id]]) !!}

                        <div class="form-group">
                            {!! Form::label('comment', 'Comment', ['class' => 'control-label']) !!}
                            {!! Form::textarea('comment', null, ['class'=>'form-control', 'size'=>'30x5']) !!}
                        </div>

                        <div class="form-group">
                            {!!Form::label('rate-1', '1', array('class' => 'rate-1'))!!}
                            {!! Form::radio('rate', '1', '',array('class' => 'rate-1', 'id' => 'rate-1')) !!}

                            {!!Form::label('rate-2', '2', array('class' => 'rate-2'))!!}
                            {!! Form::radio('rate', '2', '',array('class' => 'rate-2', 'id' => 'rate-2')) !!}

                            {!!Form::label('rate-3', '3', array('class' => 'rate-3'))!!}
                            {!! Form::radio('rate', '3', '',array('class' => 'rate-3', 'id' => 'rate-3')) !!}

                            {!!Form::label('rate-4', '4', array('class' => 'rate-4'))!!}
                            {!! Form::radio('rate', '4', '',array('class' => 'rate-4', 'id' => 'rate-4')) !!}

                            {!!Form::label('rate-5', '5', array('class' => 'rate-5'))!!}
                            {!! Form::radio('rate', '5', '',array('class' => 'rate-5', 'id' => 'rate-5')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Save', ['class'=>'btn btn-default']) !!}
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
    @else
        <div>You aren't supposed to be here.</div>
    @endif
@stop