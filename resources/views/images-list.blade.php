@extends('layout')

@section('content')

    <p> Blaaa </p>
    <div class="row">
        @if(count($images) > 0)
            <!-- POGLEDAJ URL bice ti jasno -->
            <div class="col-md-12 text-center" >
                <a href="{{ url('profile/' . \Auth::user()->id .'/image/create') }}" class="btn btn-primary" role="button">
                    Add New Image
                </a>
                <hr />
                @include('error-notification')
            </div>
        @endif
        @forelse($images as $image)
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="{{asset($image->file)}}" />
                    <div class="caption">
                        <h3>{{$image->caption}}</h3>
                        <p>{!! substr($image->description, 0,100) !!}</p>
                        <p>
                        <div class="row text-center" style="padding-left:1em;">
                            <a href="{{ url('/image/'.$image->id.'/edit') }}" class="btn btn-warning pull-left">Edit</a>
                            <span class="pull-left">&nbsp;</span>
                            {!! Form::open(['url'=>'/image/'.$image->id, 'class'=>'pull-left']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick'=>'return confirm(\'Are you sure?\')']) !!}
                            {!! Form::close() !!}
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p>No images yet, <a href="{{ url('profile/' . \Auth::user()->id .'/image/create') }}">add a new one</a>?</p>
        @endforelse
    </div>
    <div align="center">{!! $images->render() !!}</div>
@endsection