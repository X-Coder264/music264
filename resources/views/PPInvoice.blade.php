<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Artsenal</title>

    <link href="/assets/css/app.css" rel="stylesheet">

        <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        img{
            max-width:200px;
            max-height: 200px;
        }
    </style>

</head>

<body>

<div class="container-fluid">
    <header>
        <img src="/var/www/Artsenal/public/assets/logo.png" alt="SoundFeed logo" style="float: right;">
        <p style="float:right;">SoundFeed</p>
        <div style="clear: both;"></div>
    </header>

    <br> <hr> <br>

    <table class="table table-striped table-bordered table-hover table-responsive">
        <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Your name on Artsenal</th>
            <th>Paid from email</th>
            <th>Bought from</th>
            <th>Service</th>
            <th>Amount</th>
            <th>Transaction date and time</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td><h4>{{$data['transaction_id']}}</h4></td>
                <td>{{$data['buyer_Artsenal_name']}}</td>
                <td><p>{{$data['payer_email']}}</p></td>
                <td><p>{{$data['seller_Artsenal_name']}}</p></td>
                <td><p>{{$data['bought_service_name']}}</p></td>
                <td><p>{{$data['transaction_amount']}} {{$data['transaction_currency']}}</p></td>
                <td><p>{{$data['transaction_time']}}</p></td>
            </tr>
        </tbody>
    </table>

    <div style="float:right;">Total amount: {{$data['transaction_amount']}} {{$data['transaction_currency']}}</div>

</div>


<script src="/assets/js/app.js"></script>

</body>
</html>