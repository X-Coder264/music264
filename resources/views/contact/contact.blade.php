@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <h2>CONTACT US</h2>

            <form action="/contact" method="post" >
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="row control-group">
                    <div class="form-group col-xs-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}">
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 controls">
                        <label for="message">Message</label>
                        <textarea rows="5" class="form-control" id="message"
                                  name="message">{{ old('message') }}</textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-warning">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection