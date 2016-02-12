<div class="form-group">
    <label for="name" class="control-label">Description</label>
    <div>
        <textarea name="description" class="form-control" value="{{ old('description') }}" id="description" placeholder="Description"></textarea>
    </div>
</div>

<div class="form-group">
    <label for="location" class="control-label">Location</label>
    <div>
        <input type="text" name="location" class="form-control" value="{{ old('location') }}" id="location" placeholder="Location">
    </div>
</div>

<div class="form-group">
    <label for="genre" class="contol-label">Preferred genres</label>
    <div>
        @foreach ($genres as $genre)
            <div class="col-md-6">
                <label class="col-lg-8" for="{{$genre->id}}">{{$genre -> name}}</label>
                <input tabindex="1" type="checkbox" data-size="mini" data-on-color="info" name="genre[]" id="{{$genre->id}}" value=" {{$genre->id}}">
            </div>
        @endforeach
    </div>
</div>
