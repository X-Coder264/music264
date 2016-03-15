@include('auth.startRegForm')
<input type="hidden" name="accType" value="1">
<input type="hidden" name="busType" value="0">
<div class="form-group">
    <label class="control-label">Description</label>
    <div>
        <textarea name="description" class="form-control" value="{{ old('description') }}" placeholder="Description"></textarea>
    </div>
</div>

<div class="form-group">
    <label class="control-label">Location</label>
    <div>
        <input type="text" name="location" class="form-control" value="{{ old('location') }}" placeholder="Location">
    </div>
</div>

<div class="form-group">
    <label class="contol-label">Preferred genres</label>
    <div>
        @foreach ($genres as $genre)
            <div class="col-md-6">
                <label class="col-lg-8" for="{{$genre->id}}">{{$genre->name}}</label>
                <input tabindex="1" type="checkbox" data-size="mini" data-on-color="info" name="genre[]" id="{{$genre->id}}" value="{{$genre->id}}">
            </div>
        @endforeach
    </div>
</div>
@include('auth.endRegForm')
