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

    @if (Auth::check())
        <li {!! Request::is('user/' . Auth::user()->id) ? 'class="active"' : '' !!}>
            <a href="{{ route('frontend::user::profile', ['id' => Auth::user()->id]) }}">
                <i class="ti-home"></i>
                <p>Profile</p>
            </a>
        </li>
    @endif

</ul>