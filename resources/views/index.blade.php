@extends('layout')

@section('content')
 
@include('partials.slideshow')

<br>
@for ($i = 0; $i<count($status); $i++)

    <div class="row">

        @for ($j = 0; $j<count($users); $j++)
            @if($users[$j]->id == $status[$i]->user_id)
                @if($users[$j] -> image_path)
                <img class="card-bkimg col-md-1" alt="" src="{{ asset($users[$j] -> image_path) }}">
                @else
                    <img class="card-bkimg col-md-1" alt="" src="/imgs/profile_default_avatar.jpg">
                @endif

                <div class="col-md-10">
                    <p>{{$users[$j] -> name}}</p>
                    <div><p>{{ $status[$i]->text }}</p></div>
                </div>

            @endif
        @endfor

    </div>

<hr>
@endfor


@endsection

