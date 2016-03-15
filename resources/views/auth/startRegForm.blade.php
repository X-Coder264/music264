<form method="POST" action="/auth/register" class="form-horizontal">
    {!! csrf_field() !!}

    <div class="form-group">
        <label class="control-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
    </div>

    <div class="form-group">
        <label class="control-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
    </div>

    <div class="form-group">
        <label class="control-label">Password</label>
        <input type="password" name="password"  class="form-control" placeholder="Password">
    </div>

    <div class="form-group">
        <label class="control-label">Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
    </div>