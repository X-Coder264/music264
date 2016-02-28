@extends('layout')

@section('content')
    @if( Session::has('message') )
        <div class="alert alert-success" role="alert" align="center">
            <ul>
                <?php echo Session::get('message'); ?>
            </ul>
        </div>
    @endif

        @if(!empty($NonApprovedServices))
            <table class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                <tr>
                    <th>Service name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Approval</th>
                </tr>
                </thead>
                <tbody>
                @for($i=0; $i<count($NonApprovedServices); $i++)
                    <tr>
                        <td>{{$NonApprovedServices[$i]->service}}</td>
                        <td><p>{{$NonApprovedServices[$i]->description}}</p></td>
                        <td><p>{{$NonApprovedServices[$i]->price}} {{$NonApprovedServices[$i]->currency}}</p></td>
                        <td>
                            <a class="btn btn-default" href="{{'service_requests/' . $NonApprovedServices[$i]->user_id . '/' . $NonApprovedServices[$i]->service_id}}">Approve</a>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        @else
            <p>There are no service requests to be approved at the moment.</p>
        @endif


@endsection