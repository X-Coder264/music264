@extends('layout')
@section('content')
    @if(\Auth::user()->can('see-paypal-transactions') || \Auth::user()->id == $OwnerID)
            @if(!empty($userTransactions))
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Paid from email</th>
                        <th>Bought from</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Transaction date and time</th>
                        <th>Invoice</th>
                    </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<count($userTransactions); $i++)
                        <tr>
                            <td><h4>{{$userTransactions[$i]->transaction_id}}</h4></td>
                            <td><p>{{$userTransactions[$i]->payer_email}}</p></td>
                            <td><p>{{$payeesNames[$i]}}</p></td>
                            <td><p>{{$ServiceNames[$i]}}</p></td>
                            <td><p>{{$userTransactions[$i]->transaction_amount}} {{$userTransactions[$i]->transaction_currency}}</p></td>
                            <td><p>{{$userTransactions[$i]->transaction_time}}</p></td>
                            <td><a href="{{$userTransactions[$i]->invoice_path}}">Download invoice</a></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            @else
                <p>You haven't made any transactions yet.</p>
            @endif
    @else
        <p>You don't have the permission to see this.</p>
    @endif
@endsection