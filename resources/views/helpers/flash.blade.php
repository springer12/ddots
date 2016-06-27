<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <h4 class="text-center alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
        @endif
    @endforeach
</div>
