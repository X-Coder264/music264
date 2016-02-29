@extends('layout')
@section('content')
    <div class="container">
        @if(!empty($services))
            @foreach($services as $service)
                    <div>{{$service->service}} {{$service->price}} {{$service->currency}}</div>
            @endforeach
        @endif
    </div>
    @endsection
