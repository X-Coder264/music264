@extends('layout')
@section('styles')
    <link href="/assets/css/custom.css" rel="stylesheet">
    <style>
        a{
            color: #000000;
            font-weight: bold;
        }

        div.text-container {
            margin: 0 auto;
        }

        .hideContent {
            overflow: hidden;
            line-height: 1em;
            height: 2em;
        }

        .showContent {
            line-height: 1em;
            height: auto;
        }
        .show-more {
            padding: 10px 0;
            text-align: center;
        }
    </style>
@stop
@section('content')
        @if(!empty($services))
            @foreach($services as $service)
                    <div class="text-container message bg-new">
                        <a href="/profile/{{$service->slug}}"><p>{{$service->name}} - {{$service->service}} <span style="float:right">{{$service->price}} {{$service->currency}}</span></p></a>
                        <div class="content hideContent">
                        {{$service->description}}
                        </div>
                        <div class="show-more">
                            <a href="#">Show more</a>
                        </div>
                    </div>
            @endforeach
        @endif
    @endsection

@section('scripts')
    <script src="/assets/js/jquery-ui.js"></script>
    <script>
        $(".show-more a").on("click", function() {
        var $this = $(this);
        var $content = $this.parent().prev("div.content");
        var linkText = $this.text().toUpperCase();

        if(linkText === "SHOW MORE"){
        linkText = "Show less";
        $content.switchClass("hideContent", "showContent", 400);
        } else {
        linkText = "Show more";
        $content.switchClass("showContent", "hideContent", 400);
        };

        $this.text(linkText);
        });
    </script>
    @stop
