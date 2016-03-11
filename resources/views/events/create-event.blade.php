@extends('layout')

@section('styles')
    <link href="/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-tagsinput-typeahead.css" rel="stylesheet">
@stop

@section('content')
    {!!   Form::open(array('url' => 'event')) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name of the event') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('description', 'Description of the event') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>

    @if(Entrust::hasRole('artist'))
        <div class="form-group">
            {!! Form::label('venue', 'Where is this event going to take place?') !!}
            <input type="text" name="venue" data-role="tagsinput" class="form-control" id="venue" required>
        </div>
    @endif

    @if(Entrust::hasRole('Venue'))
        <div class="form-group">
            {!! Form::label('artist', 'Who is going to be the main artist?') !!}
            <input type="text" name="artist" data-role="tagsinput" class="form-control" id="artist" required>
        </div>
    @endif

    <div class="form-group">
        <div id="datetimepicker">
            <p>Date and time of the event</p>
            {!! Form::hidden('time', null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::submit('Create', ['class' => 'btn btn-default']) !!}
    </div>

    {!! Form::close() !!}
@stop

@section('scripts')
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker({
                inline: true,
                sideBySide: true,
                format: "YYYY-MM-D HH:mm",
            });
        });
    </script>
    <script src = "/assets/js/typeahead.bundle.min.js"></script>
    <script src = "/assets/js/bootstrap-tagsinput.min.js"></script>

    @if(Entrust::hasRole('artist'))
    <script>
        var venues = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '/getVenues',
                ttl: 0
            }
        });
        venues.initialize();

        var elt = $('#venue');
        elt.tagsinput({
            itemValue: 'value',
            itemText: 'text',
            typeaheadjs: {
                name: 'venues',
                displayKey: 'text',
                source: venues.ttAdapter()
            }
        });
    </script>
    @endif

    @if(Entrust::hasRole('Venue'))
        <script>
            var artists = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: {
                    url: '/getArtists',
                    ttl: 0
                }
            });
            artists.initialize();

            var elt = $('#artist');
            elt.tagsinput({
                itemValue: 'value',
                itemText: 'text',
                typeaheadjs: {
                    name: 'artists',
                    displayKey: 'text',
                    source: artists.ttAdapter()
                }
            });
        </script>
    @endif
@stop