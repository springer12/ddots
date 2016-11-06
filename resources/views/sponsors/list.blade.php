<div class="container">
    <div class="row">
        @foreach($sponsors as $sponsor)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="{{ $sponsor->link }}"><img src="{{ $sponsor->image }}"
                                                                        alt="sponsor-logo"
                                                                        class="sponsor-logo"/></a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="{{ $sponsor->link }}">{{ $sponsor->name }}</a>
                                </div>
                                <div class="col-xs-4 breaking-word">
                                    {{ $sponsor->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="col-md-12 align-center">{{ $sponsors->links() }}</div>
    </div>
</div>