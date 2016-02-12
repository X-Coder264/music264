@extends('layout')


@section('content')


    <div>
        <div class="container">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::route('profile', $user->slug)}}">{{$user->name}}</a>
                @if(Auth::user()->id == $user->id)
                <ul class="nav navbar-nav">
                    <li><a href="{{URL::route('createAlbum', $user->slug)}}">Create New Album</a></li>
                </ul>
                @endif
      </div>
    </div>


    <div class="container">

        <div>

            <div class="row">
                @foreach($user->Album as $album)
                    <div class="col-lg-3">
                        <div class="thumbnail" style="min-height: 414px;">
                            <img alt="{{$album->name}}" src="/users/{{$user->slug}}/albums/{{$album->slugAlbum}}/{{$album->cover_image}}">
                            <div class="caption">
                                <h3>{{$album->name}}</h3>
                                <p>{{$album->description}}</p>
                                <p>{{count($album->Photos)}} image(s).</p>
                                <p>Created:  {{ \Carbon\Carbon::createFromTimeStamp(strtotime($album->created_at))->diffForHumans() }}</p>
                                <p><a href="{{URL::route('show_album', ['user' => $user->slug, 'idAlbum' => $album->slugAlbum])}}" class="btn btn-big btn-default">Show Album</a>
                                    @if(Auth::user()->id == $user->id)
                                        <a href="{{URL::route('delete_album',[$user->slug, $album->slugAlbum])}}" onclick="return confirm('Are you sure?')"> <button type="button" class="btn btn-danger btn-large">Delete Album</button></a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>



@endsection
