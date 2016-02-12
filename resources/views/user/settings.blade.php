@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <br>

            <div class="col-md-6 col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Info</div>
                    <div class="panel-body">

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        {!! Form::model($user, array('route' => 'user_updateData', 'id'=>'my-dropzone', 'files'=>'true')) !!}

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
                                @foreach($services as $service)
                                        <label class="checkbox">
                                           @if(!empty($checkedServicesID) && in_array($service->id, $checkedServicesID))
                                                    <input type="checkbox" name="services[]" value="{{$service->id}}" checked> {{$service->name}}
                                            @else
                                                    <input type="checkbox" name="services[]" value="{{$service->id}}"> {{$service->name}}
                                            @endif
                                        </label>
                                @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($checkedServices))
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Prices and description of your services</label>
                            <div class="col-sm-10">
                                @for($i = 0; $i<count($checkedServices); $i++)
                                        {{$checkedServices[$i]->name}}
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




            </div>

           <div class="col-md-6 col-sm-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Images</div>

                    <div class="panel-body">

                        <div class="col-md-12">
                            <div class="jumbotron how-to-create" >

                                <h3>Images <span id="photoCounter"></span></h3>
                                <br />

                                {!! Form::open(['class' => 'dropzone', 'files'=>true, 'id'=>'real-dropzone']) !!}

                                <div class="dz-message">

                                </div>

                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>

                                <div class="dropzone-previews" id="dropzonePreview"></div>

                                <h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>

                                {!! Form::close() !!}

                            </div>
                            <div class="jumbotron how-to-create">
                                <ul>
                                    <li>Images are uploaded as soon as you drop them</li>
                                    <li>Maximum allowed size of image is 8MB</li>
                                </ul>

                            </div>
                        </div>

                        <!-- Dropzone Preview Template -->
                        <div id="preview-template" style="display: none;">

                            <div class="dz-preview dz-file-preview">
                                <div class="dz-image"><img data-dz-thumbnail=""></div>

                                <div class="dz-details">
                                    <div class="dz-size"><span data-dz-size=""></span></div>
                                    <div class="dz-filename"><span data-dz-name=""></span></div>
                                </div>
                                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

                                <div class="dz-success-mark">
                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>Check</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                        </g>
                                    </svg>
                                </div>

                                <div class="dz-error-mark">
                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>error</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>

                            </div>
                        </div>
                        <!-- End Dropzone Preview Template -->


                    </div>
                </div>
            </div>



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
