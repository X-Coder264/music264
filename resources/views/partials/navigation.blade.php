<ul class="nav navbar-nav navbar-right">

    <li>
        <a href="javascript:void(0);" data-toggle="search" class="hidden-xs">
            <i class="pe-7s-search"></i>

        </a>
    </li>





        <li><a href="/services" class="text">Services</a></li>
        <li><a href="/faq">FAQ</a></li>
        <li><a href="/contact">Contact us</a></li>
        <li><a href="{{ route('testing') }}">Testing</a></li>



        @if (Auth::guest())
        <li ><a href="/auth/register">Register</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="pe-7s-user"></i>
                <p class="navbar-text">Login</p>
            </a>
            <div class="dropdown-menu login-form" style="text-align: center;">
                @include('auth.login')
            </div>
        </li>
        @else

            <li>
                <a href="{{URL::to('messages')}}">
                    <i class="pe-7s-mail">
                        <span class="label">@include('messenger.unread-count')</span>
                    </i>

                </a>
            </li>

            @if(Entrust::hasRole('admin') || Entrust::hasRole('mod'))
            <li><a href="staffcp">Staff CP</a></li>
                @endif
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="pe-7s-user"></i>
                <p class="navbar-text">{{Auth::user()->name}}</p>
            </a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('profile',  Auth::user()->slug) }}"><i class="fa fa-user fa-fw"></i> Profile</a></li>
                <li><a href="/profile/settings"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
        </li>
    @endif



</ul>

<form class="navbar-form navbar-right navbar-search-form" role="search">
    <div class="form-group">
        <input type="text" value="" class="form-control" placeholder="Search...">
    </div>
</form>


