<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-right">

        <li><a href="{{ route('testing') }}">Testing</a></li>

        <li><a href="/services">Services</a></li>    
        <li><a href="/faq">FAQ</a></li>    
        <li><a href="/contact">Contact us</a></li> 
        <li>
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </li>
        @if (Auth::guest())         
        <li><a href="/auth/register">Register</a></li> 
        <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
            <div class="dropdown-menu login-form">
                @include('auth.login')
            </div>
        </li>


        @else
            <li class="active"><a href="{{URL::to('messages')}}">Messages @include('messenger.unread-count')</a></li>

        <li class="dropdown">            
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
               aria-expanded="false">
                <i class="fa fa-user fa-fw"></i>
                {{ Auth::user()->name }}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('profile',  Auth::user()->slug) }}"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                <li><a href="/profile/settings"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
        </li>
            @if(Entrust::hasRole('admin') || Entrust::hasRole('mod'))
            <li><a href="staffcp">Staff CP</a></li>
                @endif
        @endif
    </ul>

</div>

