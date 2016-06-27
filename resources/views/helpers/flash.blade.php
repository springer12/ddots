<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="text-center alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
    @endforeach
</div>
