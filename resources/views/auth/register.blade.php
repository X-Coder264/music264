@extends('layout')

@section('styles')
    <link href="/assets/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    @endsection

@section('content')

    <div class="col-lg-4 col-lg-offset-4">

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <form method="POST" action="/auth/register" class="form-horizontal" id="registerForm">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="name" class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Name">
            </div>

            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="Email">
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" id="password"  class="form-control" placeholder="Password">
            </div>

            <div class="form-group">
                <label for="passwordConf" class="control-label">Confirm password</label>
                <input type="password" id="passwordConf" name="password_confirmation" class="form-control" placeholder="Confirm password">
            </div>


            <div class="form-group">
                <label for="accType" class="control-label">Select type of account</label>

                <div class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="accType" value="0" >

                        <span><i class="fa fa-user"></i></span> User
                        <br>
                        <small>Find your favourite band</small>

                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="accType" value="1" >
                        <span><i class="fa fa-briefcase"></i></span> Business
                        <br>
                        <small>Find new opportunities</small>

                    </label>
                </div>
            </div>

            <div class="form-group">
                <div id="bussType" class="btn-group btn-group-justified" data-toggle="buttons">
                    <label class="btn btn-default">
                        <input type="radio" name="busType" value="0" /> <span><i class="fa fa-music"></i></span> Artist
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="busType" value="1" /> <span><i class="fa fa-microphone"></i></span> Service provider
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="busType" value="2" /> <span><i class="fa fa-credit-card"></i></span> Venue
                    </label>
                </div>
            </div>

            <div id="accountData0" hidden>
                @include('auth.accountType.user')
            </div>
            <div id="accountData1" hidden>
                @include('auth.accountType.artist')
            </div>
            <div id="accountData2" hidden>
                @include('auth.accountType.serviceProvider')
            </div>
            <div id="accountData3" hidden>
                @include('auth.accountType.venue')
            </div>

            <div class="form-group">
                <div>
                    <button type="submit" class="btn btn-warning col-lg-6 col-lg-offset-3">Register</button>
                </div>
            </div>
        </form>

    </div>

@endsection

@section('scripts')
    <script src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script>

        $('#bussType').hide();

        $('#registerForm input[name=accType]').on('change', function() {
            var account = $('input[name=accType]:checked', '#registerForm').val();
            if (account == "0") {
                $('#bussType').remove();
                $('#accountData0').slideToggle();
                $('#accountData1').remove();
                $('#accountData2').remove();
                $('#accountData3').remove();
                console.log("user");
            } else if (account == "1") {
                $('#bussType').fadeToggle();
                $('#accountData0').hide();
                console.log("business");
            }
        });

        $('#registerForm input[name=busType]').on('change', function() {
            var account = $('input[name=busType]:checked', '#registerForm').val();
            if (account == "0") {
                $('#accountData1').fadeToggle();
                $('#accountData2').hide();
                $('#accountData3').hide();
            } else if (account == "1") {
                $('#accountData1').hide();
                $('#accountData2').fadeToggle();
                $('#accountData3').hide();
            } else if (account == "2") {
                $('#accountData1').hide();
                $('#accountData2').hide();
                $('#accountData3').fadeToggle();
            }
        });


        $("[name='genre[]']").bootstrapSwitch();


        $('.datepicker').datepicker({
            format: "dd.mm.yyyy",
            weekStart: 1,
            startDate: "01.01.1945",
            endDate: "31.12.2001"
        });


    </script>
@endsection