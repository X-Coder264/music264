@extends('layout')

@section('content')
 
{{--@include('partials.slideshow')--}}

<br>
<div class="container">
@for ($i = 0; $i<count($status); $i++)

    <div class="well">
    <div class="row">

        @for ($j = 0; $j<count($users); $j++)
            @if($users[$j]->id == $status[$i]->user_id)
                <div class="">
                    <h4 style="margin-top: 0; margin-bottom: 0; margin-left: 20px;">{{$users[$j] -> name}}</h4>
                    @if($users[$j] -> image_path)
                        <img class="card-bkimg col-md-1" alt="" src="{{ asset($users[$j] -> image_path) }}">
                    @else
                        <img class="card-bkimg col-md-1" alt="" src="/imgs/profile_default_avatar.jpg">
                    @endif
                </div>

                <div class="col-md-10">
                    <blockquote>
                        <p>{{ $status[$i]->text }}</p>
                    <footer>{{\Carbon\Carbon::parse($status[$i] -> updated_at )->diffForHumans()}}</footer>

                    </blockquote>
                </div>



            @endif
        @endfor

    </div>
</div>
@endfor
</div>

@endsection

