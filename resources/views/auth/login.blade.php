<form method="POST" action="/auth/login" class="form-horizontal">
    {!! csrf_field() !!}
    <div class="form-group">
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="Email">
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password"  class="form-control" placeholder="Password">
    </div>
    <div class="form-group">
            <label>
                <input type="checkbox" name="remember" checked> Remember me
            </label>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-warning login-button">Login</button>
    </div>
</form>
<a href="/login/facebook">Login in with Facebook</a>