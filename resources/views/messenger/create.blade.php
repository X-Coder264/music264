@extends('layout')

@section('styles')
    <link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-tagsinput-typeahead.css" rel="stylesheet">
    @endsection

@section('content')
    <div class="container">
<h1>Create a new message</h1>
{!! Form::open(['route' => 'messages.store']) !!}


    <div class="form-group">
        {!! Form::label('recipients', 'Name of the receiver', ['class' => 'control-label']) !!}
        <input type="text" name="recipients[]" data-role="tagsinput" class="form-control" id="recipients" required>
    </div>
    <!-- Subject Form Input -->
    <div class="form-group">
        {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
        {!! Form::text('subject', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Message Form Input -->
    <div class="form-group">
        {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    </div>
    
    <!-- Submit Form Input -->
    <div class="form-group">
        {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
    </div>

{!! Form::close() !!}
    </div>
@stop

@section('scripts')
    <script src = "/assets/js/typeahead.bundle.min.js"></script>
    <script src = "/assets/js/bootstrap-tagsinput.min.js"></script>

    <script>
        var users = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '/messages/getUsers',
                ttl: 0
            }
        });
        users.initialize();

        var elt = $('#recipients');
        elt.tagsinput({
            itemValue: 'value',
            itemText: 'text',
            typeaheadjs: {
                name: 'users',
                displayKey: 'text',
                source: users.ttAdapter()
            }
        });
    </script>
    @stop
