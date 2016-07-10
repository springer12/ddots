<ul class="nav">
    <li {!! Request::is('/') ? 'class="active"' : '' !!}>
        <a href="{{ url('/') }}">
            <i class="ti-home"></i>
            <p>Home</p>
        </a>
    </li>

    <li {!! Request::is('teachers') ? 'class="active"' : '' !!}>
        <a href="{{ url('/teachers') }}">
            <i class="ti-search"></i>
            <p>Teachers</p>
        </a>
    </li>

    @if (Auth::check())
        <li {!! Request::is('user/' . Auth::user()->id) ? 'class="active"' : '' !!}>
            <a href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">
                <i class="ti-user"></i>
                <p>Profile</p>
            </a>
        </li>
    @endif

    @if (Auth::check() && Auth::user()->hasRole(App\User::ROLE_TEACHER))
        <li {!! Request::is('groups/') ? 'class="active"' : '' !!}>
            <a href="{{ url('/groups') }}">
                <i class="ti-user"></i>
                <p>Groups</p>
            </a>
        </li>

        <li {!! Request::is('students/') ? 'class="active"' : '' !!}>
            <a href="{{ url('/students') }}">
                <i class="ti-user"></i>
                <p>Students</p>
            </a>
        </li>
    @endif

</ul>