<form method="POST" action="/auth/login" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group">
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password"  class="form-control" placeholder="Password">
    </div>

    <div class="form-group col-lg-12 col-lg-offset-1">
        <button type="submit" class="btn btn-primary login-button">Login</button>
    </div>

    <div class="form-group col-lg-12 col-lg-offset-1">
        <a href="/login/facebook"><button type="submit" class="btn btn-primary login-button">Login in with Facebook</button></a>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="remember" checked> Remember me
        </label>
    </div>

</form>