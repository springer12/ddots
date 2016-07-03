<ul class="nav">
    <li {!! Request::is('/') ? 'class="active"' : '' !!}>
        <a href="{{ url('/') }}">
            <i class="ti-home"></i>
            <p>Home</p>
        </a>
    </li>

    <li {!! Request::is('teachers') ? 'class="active"' : '' !!}>
        <a href="{{ url('/teachers') }}">
            <i class="ti-home"></i>
            <p>Teachers</p>
        </a>
    </li>

    @if (Auth::guest())
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
        <li {!! Request::is('user/' . Auth::user()->id) ? 'class="active"' : '' !!}>
            <a href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">
                <i class="ti-home"></i>
                <p>Profile</p>
            </a>
        </li>
        <li {!! Request::is('logout') ? 'class="active"' : '' !!}>
            <a href="{{ url('/logout') }}">
                <i class="ti-home"></i>
                <p>Logout</p>
            </a>
        </li>
    @endif


</ul>