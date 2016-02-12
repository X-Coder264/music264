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