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
                    <div class="text-container message">
                        <a href="/profile/{{$service->slug}}"><p>{{$service->name}} - {{$service->service}} <span style="float:right">{{$service->price}} {{$service->currency}}</span></p></a>
                        <div class="content hideContent">
                        <?php echo nl2br($service->description); ?>
                                @if(!empty($service->arrayofRatings))
                                <div>
                                    <p>What have other users said about this service?</p>
                                    @foreach($service->arrayofRatings as $rating)
                                        <div class="bg-new content">
                                            Rating: {{$rating['value']}} n<span style="float: right;">{{\Carbon\Carbon::parse($rating['time'])->diffForHumans()}} - <a href="/profile/{{$rating['commUserSlug']}}">{{$rating['commUser']}}</a></span> <br><br>
                                            {{$rating['comment']}}
                                            <hr>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                    <div>There are no user comments or ratings for this service at the moment.</div>
                                @endif
                        </div>
                        <div class="show-more">
                            <a href="#">Show more</a>
                        </div>
                    </div>
            @endforeach
        @else
            <div class="text-container message bg-new">
                There are currently no available services of this type.
            </div>
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
