@extends('layout')

@section('content')
 @if( Session::has('message') &&  Session::get('message') == 'Payment successful')
     <div>Payment successful. You have paid {{Session::get('transaction_amount')}} {{Session::get('transaction_currency')}}.<br>
     You can download your invoice <a href="{{Session::get('invoice_url')}}">here</a>.<br>
     After this service has been delivered, please rate and comment it in your profile (tab Info).</div>
 @else
     <div>Payment failed. Something went wrong.</div>
 @endif

    @endsection