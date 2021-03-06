<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('blog.title') }} SoundFeed</title>



        <link href="/assets/css/app.css" rel="stylesheet">
        <link href="/assets/css/ct-navbar.css" rel="stylesheet" />
        <link href="/assets/css/bootstrap-switch.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
        <link href="/assets/css/icon-stroke-int.css" rel="stylesheet" />

        @yield('styles')

        <!--[if lt IE 9]>
          <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <div id="navbar-full">
            <div id="navbar">
                <nav class="navbar navbar-ct-orange navbar-fixed-top" role="navigation">
                <!--<nav class="navbar navbar-default navbar-static-top" role="navigation">-->
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/">{{ config('blog.title') }} SoundFeed</a>
                                <!--<div class="logo-fixed"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcScMEmPGz6veIcjLF691T14FGpthGmyJvrCALrqE1iF7WAOf7cq0FSieg"></a></div>-->
                        </div>
                        <div class="collapse navbar-collapse">
                            @include('partials.navigation')
                        </div>
                    </div>
                </nav>
            </div>
        </div>


        <div class="container">
            @yield('content')
        </div>


        <script src="/assets/js/app.js"></script>
        @yield('scripts')
        @yield('scriptsPlayer')
        <script>
        $(document).ready(function () {
            $('.carousel').carousel();
        });
        </script>
        <script>
            $(document).ready(function () {
                $('li img').on('click', function () {
                    var src = $(this).attr('src');
                    var img = '<img src="' + src + '" class="img-responsive"/>';
                    $('#myModal').modal();
                    $('#myModal').on('shown.bs.modal', function () {
                        $('#myModal .modal-body').html(img);
                    });
                    $('#myModal').on('hidden.bs.modal', function () {
                        $('#myModal .modal-body').html('');
                    });
                });
            })
        </script>
        <script src="/assets/js/navbar.js"></script>

    </body>
</html>