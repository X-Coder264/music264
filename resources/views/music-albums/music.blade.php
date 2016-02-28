
<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:100px;">


                @if(Auth::user()->id == $user->id)
                <a href="{{URL::route('add_song', $user->slug)}}">Add Song</a><br><br>
                @endif

                @foreach($user->Song as $songs)

                        <p>Naslov: {{$songs->name}}</p>

                            <div class="caption">
                                <p>Opis: {{$songs->description}}</p>
                                <p>Created:  {{ \Carbon\Carbon::createFromTimeStamp(strtotime($songs->created_at))->diffForHumans() }}</p>
                            </div>
                            @if(Auth::user()->id == $user->id)
                                <a href="{{URL::route('delete_song',[$user->slug, $songs->slugSong])}}" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-danger btn-small">Delete Song</button></a>
                            @endif
                    <br><br>
                @endforeach

    </div>
</div>
{{--@include('player')--}}

