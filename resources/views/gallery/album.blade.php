@if(Auth::user()->id == $user->id)
<div class="btn">
    <a class="btn" href="{{URL::route('createAlbum', $user->slug)}}">Create New Album</a>
</div>
@endif

    <div class="container">
        <div>

            <div class="row">
                @foreach($user->Album as $album)
                    <div class="col-lg-3">
                        <div class="thumbnail" style="min-height: 300px;">
                            <a href="{{URL::route('show_album', ['user' => $user->slug, 'idAlbum' => $album->slugAlbum])}}"><img alt="{{$album->name}}" src="/users/{{$user->slug}}/albums/{{$album->slugAlbum}}/{{$album->cover_image}}"></a>
                            <div class="caption" style="text-align:center;">
                                <h3>{{$album->name}}</h3>
                                <p>{{count($album->Photos)}} image(s).</p>
                                <p>Created:  {{ \Carbon\Carbon::createFromTimeStamp(strtotime($album->created_at))->diffForHumans() }}</p>
                                    @if(Auth::user()->id == $user->id)
                                        <a href="{{URL::route('delete_album',[$user->slug, $album->slugAlbum])}}" onclick="return confirm('Are you sure?')"> <button type="button" class="btn btn-danger btn-large">Delete Album</button></a>
                                    @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
