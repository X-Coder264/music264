@extends('layout')
@section('styles')
    <style>
        ul.img-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        ul.img-list li {
            display: inline-block;
            height: 350px;
            margin: 0 1em 1em 0;
            position: relative;
            width: 500px;
        }

        div.text-content {
            background: rgba(0,0,0,0.7);
            color: white;
            cursor: pointer;
            height: 350px;
            left: 0;
            position: absolute;
            top: 0;
            width: 500px;
            opacity: 0;
            -webkit-transition: opacity 500ms;
            -moz-transition: opacity 500ms;
            -o-transition: opacity 500ms;
            transition: opacity 500ms;
        }

        ul.img-list li:hover div.text-content {
            opacity: 1;
        }

        div.text-content div {
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%, -50%);
        }

        div.text-content div a {
            font-family: Roboto, Helvetica, Arial, sans-serif;
            font-size: 20px;
            text-decoration: none;
            color: white;
        }

        img{
            width: 500px;
            height: 350px;
        }
    </style>
    @stop

@section('content')
<div class="container">
    <h2>Services</h2>
    <ul class="img-list">
        <li>
                <img src="/imgs/studio.jpg" alt="Studio"/>
                <div class="text-content">
                    <div>
                        @foreach($services as $service)
                            @if($service->category == "Studio")
                    <a href="/service/{{$service->slug}}">{{$service->service}}</a> <br>
                            @endif
                        @endforeach
                    </div>
                </div>
        </li>
        <li>
            <img src="/imgs/studio.jpg" alt="Live"/>
            <div class="text-content">
                <div>
                    @foreach($services as $service)
                        @if($service->category == "Live")
                            <a href="/service/{{$service->slug}}">{{$service->service}}</a> <br>
                        @endif
                    @endforeach
                </div>
            </div>
        </li>
    </ul>
        <ul class="img-list">
            <li>
                <img src="/imgs/studio.jpg" alt="Promotion"/>
                <div class="text-content">
                    <div>
                        @foreach($services as $service)
                            @if($service->category == "Promotion")
                                <a href="/service/{{$service->slug}}">{{$service->service}}</a> <br>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
            <li>
                <img src="/imgs/studio.jpg" alt="Photo / Video"/>
                <div class="text-content">
                    <div>
                        @foreach($services as $service)
                            @if($service->category == "Photo / Video")
                                <a href="/service/{{$service->slug}}">{{$service->service}}</a> <br>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
        </ul>
</div>

@endsection