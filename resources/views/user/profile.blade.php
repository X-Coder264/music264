@extends('layout')

@section('styles')
    <link rel="stylesheet" href="/assets/css/profile-int.css" />

    <link rel="stylesheet" href="/assets/player/mediaelementplayer.css" />
    <link rel="stylesheet" href="/assets/player/mep-feature-playlist.css" />
    <link rel="stylesheet" href="/assets/css/ratings.css" />

@endsection

@section('content')

        @if( Session::has('message') )
            <div class="alert alert-danger" role="alert" align="center">
                <ul>
                    <?php echo Session::get('message'); ?>
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif



        <div>
                <div class="card hovercard">
                    <div class="card-background">
                        <img class="card-bkimg" alt="Thumbnail Image" src="/imgs/123.jpg">
                    </div>

                    @if( $user -> image_path == "" )
                        <div class="useravatar">
                            <img class="card-bkimg" alt="Thumbnail Image" src="/imgs/profile_default_avatar.jpg">
                        </div>
                    @else
                        <div class="useravatar">
                            <img class="card-bkimg" alt="Thumbnail Image" src="{{ asset($user -> image_path) }}">
                        </div>
                    @endif

                    <div class="card-info"> <span class="card-title">{{$user->name}}</span></div>

                    <!--BUTTONS FOR MESSAGE AND FOLLOW-->
                    @if($user->id != Auth::user()->id)
                        <div class="col-md-2 col-md-offset-10" role="group" aria-label="..." style="position:absolute; left:0; top:15px;"> <!--TODO:Ovaj position vjerovatno moze pametnije-->

                            <a href="{{URL::route('messages.create', $user->slug)}}" class="btn btn-default col-md-12" role="button">Message {{$user->name}}</a>

                            <form method="POST" class="form-horizontal">
                                {!! csrf_field() !!}

                                    @if(in_array(Auth::user()->id, $user->getAllFollowers($user->id)))
                                        <button type="submit" name="id" class="btn btn-default col-md-12" value="{{ Auth::user()->id }}" style="top:5px">Unfollow</button>
                                    @else
                                        <button type="submit" name="id" class="btn btn-default col-md-12" value="{{ Auth::user()->id }}" style="top:5px">Follow</button>
                                    @endif

                            </form>
                        </div>
                    @endif

                    @if ($user->ratingSong != 0)
                        <div class="col-md-2 col-md-offset-10" style="position:absolute; left:0; bottom:1px;">
                            <div class="thumbnail">
                                <h3 style="margin:0;">{{ number_format($user->ratingSong, 2, '.', ',') }} </h3>
                                <p style="margin:0;">Votes: {{ $user->numberOfVotes }}</p>
                            </div>
                        </div>
                    @endif

                </div>


            <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" id="stars" class="btn btn-primary" href="#General" data-toggle="tab"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                        <div class="hidden-xs">General</div>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" id="favorites" class="btn btn-default" href="#Music" data-toggle="tab"><span class="glyphicon glyphicon-music" aria-hidden="true"></span>
                        <div class="hidden-xs">Music</div>
                    </button>
                </div>

                <div class="btn-group" role="group">
                        <button type="button" id="following" class="btn btn-default" href="#Albums" data-toggle="tab"><span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                        <div class="hidden-xs">Albums</div>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" id="following" class="btn btn-default" href="#Services" data-toggle="tab"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                        <div class="hidden-xs">Services</div>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" id="following" class="btn btn-default" href="#Events" data-toggle="tab"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                        <div class="hidden-xs">Events</div>
                    </button>
                </div>

                <div class="btn-group" role="group">
                    <button type="button" id="following" class="btn btn-default" href="#Info" data-toggle="tab"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        <div class="hidden-xs">Info</div>
                    </button>
                </div>
            </div>

            <div class="well">
                <div class="tab-content">

                    <!--GENERAL-->
                    <div class="tab-pane fade in active" id="General">
                        <div id="statuses">
                            @if($user->id == \Auth::user()->id)
                                <form method="POST" class="form-horizontal" id="status">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="text" name="text" class="form-control" id="text" required>
                                    </div>

                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-warning col-lg-6 col-lg-offset-3">Post Status</button>
                                        </div>
                                    </div>
                                </form>
                            @endif

                            <div class="statuses">
                            @foreach($status as $stat)
                                    <article>{{ $stat->text }}
                                        {{ $stat->created_at->diffForHumans() }}
                                    </article>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!--MUSIC-->
                    <div class="tab-pane fade in" id="Music">
                        @include('music-albums.music')
                    </div>

                    <!--ALBUMS-->
                    <div class="tab-pane fade in" id="Albums">
                        @include('gallery.album')
                    </div>

                    <!--SERVICES-->
                    <div class="tab-pane fade in" id="Services">
                        @if(!empty($services))
                            @foreach($services as $service)
                                @if($service->approved == true)
                                    {!! Form::open(['route' => 'payment']) !!}
                                    <div>{{$service->service}} {{$service->price}} {{$service->currency}} Average rating of this service: {{number_format($service->average_rating, 2, '.', ',')}}</div>
                                    <input type="hidden" name="service_id" value="{{$service->service_id}}">
                                    <input type="hidden" name="user_id" value="{{$service->user_id}}">
                                    <button type="submit" class="btn btn-warning">Order this service</button>
                                    {!! Form::close() !!}
                                @endif
                            @endforeach
                        @endif
                    </div>


                    <!--EVENTS-->
                    <div class="tab-pane fade in" id="Events">
                        @if((Entrust::hasRole('artist') || Entrust::hasRole('Venue')) && $user->id == \Auth::user()->id)
                            <a href="{{URL::route('event')}}" class="btn btn-info" role="button">Create a new event</a>  <br>
                        @endif
                        <div>
                            @if(empty($UpcomingEvents))
                                <p>There are no upcoming events.</p>
                            @else
                                <div>Upcoming events</div>
                                @foreach($UpcomingEvents as $event)
                                    <p><a href="/event/{{$event->slug}}">{{$event->name}} {{$event->time}}</a> ({{\Carbon\Carbon::parse($event->time)->diffForHumans()}})</p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            @if(!empty($PassedEvents))
                                <div>Events that have passed</div>
                                @foreach($events as $event)
                                    <p>{{$event->name}} {{$event->time}} ({{\Carbon\Carbon::parse($event->time)->diffForHumans()}})</p>
                                @endforeach
                            @endif
                        </div>
                    </div>


                    <!--INFO-->
                    <div class="tab-pane fade in" id="Info">
                        <p>Lives in: {{ $user->location }}</p>
                        <div>
                            <p>About me:</p>
                            <p>{{ $user->description }}</p>{{ $user->description }}
                        </div>

                        <br>
                        @include('user.transactions')
                    </div>
                </div>
            </div>

            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!-- Dovde -->

        @section('scripts')
            <script src = "/assets/js/profile-int.js"></script>
            <script>
                jQuery(document).ready(function() {
                    $("#status").submit(function (event) {
                        event.preventDefault();

                        /*var values = {};
                        $.each($(this).serializeArray(), function (i, field) {
                            values[field.name] = field.value;
                        });

                         console.log(values);*/

                        var formData = $('#text').val();

                        var token = $('#status > input[name="_token"]').val();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo "/status/" . $user->slug ?>',
                            dataType: 'json',
                            headers: {'X-CSRF-TOKEN': token},
                            data: {text: formData},
                            error: function() {
                                $('.statuses').html('<p>An error has occurred</p>');
                            },
                            success: function(data) {
                                console.log(data);
                                $('.statuses').prepend("<article>" + data.text + " " + data.created_at + "</article>");
                            }
                        });
                    });
                });
            </script>
        @endsection


@endsection