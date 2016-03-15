@include('auth.startRegForm')
<input type="hidden" name="accType" value="0">
<div class="form-group">
    <label class="control-label">Date of birth</label>
    <div>
        <input type="text" class="form-control datepicker" name="dateOfBirth"  value="{{ old('dateOfBirth') }}" placeholder="Date Of Birth">
    </div>
</div>

<div class="form-group">
    <label class="control-label">Sex</label>
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