@section('styles')
    <link rel="stylesheet" href="/assets/player/mediaelementplayer.css" />
    <link rel="stylesheet" href="/assets/player/mep-feature-playlist.css" />
    <link rel="stylesheet" href="/assets/css/ratings.css" />
@endsection

<div class="player-icon">
    <button  name="id" class="player-icon" value="" >
        <i class="pe-7s-play"></i>
    </button>
</div>

<div class="audio-player">
    <audio id="audio-player" controls>
        @foreach($user->Song as $songs)
            <source class="current-song" src="/users/{{$user->slug}}/songs/{{$songs->song}}" type="audio/mp3" title="{{$songs->name}}">
        @endforeach
        Your browser does not support the audio element.
    </audio>
        <p id="song-name">Unknown</p>
        @include('ratings')
</div>

@section('scriptsPlayer')
    <script src="/assets/player/mediaelement-and-player.min.js"></script>
    <script src="/assets/player/custom.js"></script>
    <script src="/assets/player/mep-feature-playlist.js"></script>
    <script src="/assets/js/ratings.js"></script>
@endsection
