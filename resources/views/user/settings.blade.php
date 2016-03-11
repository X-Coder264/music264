@extends('layout')

@section('content')

            <br>
                 <div class="panel panel-default">
                    <div class="panel-heading">Info</div>
                    <div class="panel-body">

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        {!! Form::model($user, array('route' => 'user_updateData', 'files'=>'true')) !!}

                        <div class="form-group">
                            {!! form::label('image','Profile picture')!!}
                            {!! form::file('image',null,['class' => 'form-control']) !!}
                        </div>



                        <div class="form-group">
                            {!! Form::label('email') !!}
                            {!! Form::text('email', null,
                                array('class'=>'form-control',)) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('description') !!}
                            {!! Form::textarea('description', null,
                                array('class'=>'form-control', 'size'=>'30x5')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('location') !!}
                            {!! Form::text('location', null,
                                array('class'=>'form-control',)) !!}
                        </div>
                    @if(Entrust::hasRole('Service Provider'))
                        @if(!empty($services))
                            <div class="form-group">
                            <label class="col-sm-2 control-label">Services</label>
                                <div class="col-sm-10">
                                    <?php $var = "0"; ?>
                                @foreach($services as $service)
                                    @if($var != $service->category)
                                            @if($var != "0")
                                            <hr style = "border: 1px solid grey;">
                                            @endif
                                            <?php $var = $service->category; ?>
                                            <p>{{$var}}</p>
                                            @endif
                                        <label class="checkbox">
                                           @if(!empty($checkedServicesID) && in_array($service->id, $checkedServicesID))
                                                    <input type="checkbox" name="services[]" value="{{$service->id}}" checked> {{$service->service}}
                                            @else
                                                    <input type="checkbox" name="services[]" value="{{$service->id}}"> {{$service->service}}
                                            @endif
                                        </label>
                                @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($checkedServices))
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="margin-top: 20px;">Prices and description of your services</label>
                            <div class="col-sm-10" style="margin-top: 20px;">
                                @for($i = 0; $i<count($checkedServices); $i++)
                                        {{$checkedServices[$i]->service}}
                                        <input type="hidden" name="id[]" value="{{$checkedServices[$i]->service_id}}">
                                        <textarea name="service_description[]" class="form-control">{{$checkedServices[$i]->description}}</textarea>
                                        <input type="text" name="price[]" value="{{$checkedServices[$i]->price}}">
                                        <select class="selectpicker" name="currency[]">
                                            @if($checkedServices[$i]->currency == "EUR")
                                            <option value="1" selected="selected">EUR</option>
                                            <option value="2">USD</option>
                                            @else
                                            <option value="1">EUR</option>
                                            <option value="2" selected="selected">USD</option>
                                            @endif
                                        </select>
                                @if($checkedServices[$i]->approved == 0)
                                    <p>Your service is awaiting the approval from the Artsenal Staff.</p>
                                    @else
                                    <p>Your service is approved.</p>
                                    @endif
                                        <br>
                                @endfor
                            </div>
                        </div>

                        @endif
                    @endif

                        <div class="form-group">
                            {!! Form::submit('Save',
                              array('class'=>'btn btn-default')) !!}
                            {!! Form::reset('Cancel',
                             array('class'=>'btn btn-default')) !!}
                        </div>


                        {!! Form::close() !!}

                </div>
            </div>
@endsection

@section('scripts')


    <script>
        var photo_counter = 0;
        Dropzone.options.realDropzone = {

            uploadMultiple: false,
            parallelUploads: 100,
            maxFilesize: 8,
            previewsContainer: '#dropzonePreview',
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            dictFileTooBig: 'Image is bigger than 8MB',

            // The setting up of the dropzone
            init:function() {

                this.on("removedfile", function(file) {

                    $.ajax({
                        type: 'POST',
                        url: 'upload/delete',
                        data: {id: file.name},
                        dataType: 'html',
                        success: function(data){
                            var rep = JSON.parse(data);
                            if(rep.code == 200)
                            {
                                photo_counter--;
                                $("#photoCounter").text( "(" + photo_counter + ")");
                            }

                        }
                    });

                } );
            },
            error: function(file, response) {
                if($.type(response) === "string")
                    var message = response; //dropzone sends it's own error messages in string
                else
                    var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            },
            success: function(file,done) {
                photo_counter++;
                $("#photoCounter").text( "(" + photo_counter + ")");
            }
        }
    </script>
@endsection
