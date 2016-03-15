@include('auth.startRegForm')
<input type="hidden" name="accType" value="1">
<input type="hidden" name="busType" value="1">
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
    <label class="control-label">Services</label>
    <div>
        {!! Form::checkbox('options[0]', 'value1') !!} Production
        {!! Form::checkbox('options[1]', 'value2') !!} Mix
    </div>
</div>
@include('auth.endRegForm')