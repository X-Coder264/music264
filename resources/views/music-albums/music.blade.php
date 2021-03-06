
<div class="container" style="text-align: center;">
    <div class="span4" style="display: inline-block;margin-top:10px;">

                @if(Auth::user()->id == $user->id)
                <a href="{{URL::route('add_song', $user->slug)}}">Add Song</a><br><br>
                @endif

                @if(count($user->Song)==0)
                     <p>There is no uploaded songs.</p>
                @endif

                @foreach($user->Song as $songs)

                        <h4>{{$songs->name}}</h4>

                            <div class="caption">
                                <p>{{$songs->description}}</p>
                                <p>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($songs->created_at))->diffForHumans() }}</p>
                            </div>
                            @if(Auth::user()->id == $user->id)
                                <a href="{{URL::route('delete_song',[$user->slug, $songs->slugSong])}}" onclick="return confirm('Are you sure?')"><button type="button" class="btn btn-danger btn-small">Delete Song</button></a>
                            @endif
                    <br><br>
                @endforeach

    </div>

</div>

@if(count($user->Song)!=0)
    @include ('player')
@endif
