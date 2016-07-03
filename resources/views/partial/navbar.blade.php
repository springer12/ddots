<ul class="nav navbar-nav navbar-right">
    @if(Auth::guest())
        <li {!! Request::is('login') ? 'class="active"' : '' !!}>
            <a href="{{ url('/login') }}">
                <i class="ti-home"></i>
                <p>Login</p>
            </a>
        </li>
        <li {!! Request::is('register') ? 'class="active"' : '' !!}>
            <a href="{{ url('/register') }}">
                <i class="ti-home"></i>
                <p>Register</p>
            </a>
        </li>
    @else
        <li {!! Request::is('logout') ? 'class="active"' : '' !!}>
            <a href="{{ url('/logout') }}">
                <i class="ti-home"></i>
                <p>Logout</p>
            </a>
        </li>
    @endif
</ul>