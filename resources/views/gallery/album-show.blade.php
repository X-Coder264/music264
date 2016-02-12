@extends ('layout')
@section ('styles')
    <link href="/assets/css/lightbox.css" rel="stylesheet">
@endsection

@section ('content')

<div class="container">

    <div class="starter-template">
        <div class="media">
            <div class="media-body">
                <h1>{{$album->name}}</h1>
                <div class="media">
                    <p>{{$album->description}}<p>
                        @if(Auth::user()->id == $user->id)
                        <a href="{{URL::route('add_image', [$user->slug, $album->slugAlbum])}}"><button type="button" class="btn btn-primary btn-large">Add New Image to Album</button></a>
                        @endif
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        @foreach($album->Photos as $photo)
            <div class="col-lg-3">
                <div class="thumbnail" style="max-height: 350px;min-height: 350px;">
                    <a href="/users/{{$user->slug}}/albums/{{$album->slugAlbum}}/{{$photo->image}}"  data-lightbox="{{$album->slugAlbum}}">
                    <img alt="{{$album->name}}" src="/users/{{$user->slug}}/albums/{{$album->slugAlbum}}/{{$photo->image}}">
                    </a>
                    <div class="caption">
                        <p>{{$photo->description}}</p>
                        <p>Created:  {{ \Carbon\Carbon::createFromTimeStamp(strtotime($photo->created_at))->diffForHumans() }}</p>
                        @if(Auth::user()->id == $user->id)
                        <a href="{{URL::route('delete_image',[$user->slug, $photo->slugImage])}}" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-danger btn-small">Delete Image</button></a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
@section ('scripts')
    <script src="/assets/js/lightbox.js"></script>
@endsection