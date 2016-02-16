@extends('layout')

@section('content')
    <div class="container">

        @if( Session::has('message') )
            <div class="alert alert-danger" role="alert" align="center">
                <ul>
                    <?php echo Session::get('message'); ?>
                </ul>
            </div>
        @endif

        <div class="row">
            <br>
            <div class="col-md-4 col-sm-12">
                <img class="img-thumbnail" alt="Thumbnail Image" src="{{ asset($user -> image_path) }}">
                <div>
                    <br>
                    <a href="{{URL::route('album', $user->slug)}}" class="btn btn-info" role="button">Albums</a> <br>
                    @if(Entrust::hasRole('artist'))
                    <a href="{{URL::route('music', $user->slug)}}" class="btn btn-info" role="button">Music</a>  <br>
                    @endif
                    @if(Entrust::hasRole('artist') || Entrust::hasRole('Venue'))
                        <a href="{{URL::route('event')}}" class="btn btn-info" role="button">Create a new event</a>  <br>
                    @endif
                    @if(Auth::user()->can('see-paypal-transactions') || $user->id == Auth::user()->id)
                        <a href="{{URL::route('transactions', $user->slug)}}" class="btn btn-info" role="button">Your PayPal transactions</a>
                    @endif
                    @if($user->id != Auth::user()->id)
                        <a href="{{URL::route('messages.create', $user->slug)}}" class="btn btn-info" role="button">Start a conversation with this user</a>
                        <form method="POST" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                @if(in_array(Auth::user()->id, $user->getAllFollowers($user->id)))
                                <button type="submit" name="id" class="btn btn-warning col-lg-6 col-lg-offset-3" value="{{ Auth::user()->id }}">Unfollow</button>
                                    @else
                                    <button type="submit" name="id" class="btn btn-warning col-lg-6 col-lg-offset-3" value="{{ Auth::user()->id }}">Follow</button>
                                    @endif
                            </div>

                        </form>
                        @endif
                </div>
            </div>

            <div class="col-md-4 col-sm-12">

                <h2>{{ $user->name }}</h2>
                <h3>{{ $user->location }}</h3>
                <div>
                    {{ $user->description }}
                </div>

            @if(!empty($services))
                @foreach($services as $service)
                    @if($service->approved == true)
                    {!! Form::open(['route' => 'payment']) !!}
                    <div>{{$service->name}} {{$service->price}} {{$service->currency}}</div>
                    <input type="hidden" name="service_id" value="{{$service->service_id}}">
                    <input type="hidden" name="user_id" value="{{$service->user_id}}">
                    <button type="submit" class="btn btn-warning">Order this service</button>
                    {!! Form::close() !!}
                    @endif
                @endforeach
            @endif

            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            </div>
            <div id="statuses5">
                <form method="POST" class="form-horizontal">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <input type="text" name="text" class="form-control" id="text" v-model="newStatus.text" required>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" v-on:click="onSubmitForm" class="btn btn-warning col-lg-6 col-lg-offset-3">Post Status</button>
                        </div>
                    </div>
                </form>


                <!--@foreach($status as $stat)
                        <div>{{ $stat->text }}
                        <br>
                            {{ $stat->created_at->diffForHumans() }}
                        </div>
            @endforeach
                        -->

                <article v-for="status in statuses">
                    <!--<h3>@{{ id }}</h3>-->
                    <div>@{{ status.text }} - @{{ status.created_at }}</div>
                </article>

                <!--moment(status.created_at, "YYYY-MM-DD H:M:S").fromNow();-->
            </div>
        </div>

        <script src = "/assets/js/moment.min.js"></script>
        <script src = "/assets/js/vue.min.js"></script>
        <script src = "/assets/js/vue-resource.min.js"></script>
        <script src = "/assets/js/status.js"></script>

            <div class="col-md-4 col-sm-12">
                <div class="well">Rate: </div>

                <ul class="list-group">
                    <li class="list-group-item">Kategorija 1</li>
                    <li class="list-group-item">Kategorija 2</li>
                    <li class="list-group-item">Kategorija 3</li>
                </ul>
            </div>

            <div class="col-md-12 col-sm-12">

                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Projects</h2>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                        <p>Lorem ipsum</p>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/500x300" alt="">
                    </div>
                </div>
            </div>
        </div>

@endsection