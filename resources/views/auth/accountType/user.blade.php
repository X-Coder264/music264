<div class="form-group">
    <label for="dateOfBirth" class="control-label">Date of birth</label>
    <div>
        <input type="text" class="form-control datepicker" name="dateOfBirth"  value="{{ old('dateOfBirth') }}" id="dateOfBirth" placeholder="Date Of Birth">
    </div>
</div>

<div class="form-group">
    <label for="sex" class="control-label">Sex</label>
    <div>
        <div class="radio-inline">
            <label>
                <input type="radio" class="field" name = "sex" value="M"> Male
            </label>
        </div>
        <div class="radio-inline">
            <label>
                <input type="radio" class="field" name = "sex" value="F"> Female
            </label>
        </div>
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
