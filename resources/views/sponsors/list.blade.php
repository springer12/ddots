<div class="container">
    <div class="row">
        @foreach($sponsors as $sponsor)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ $sponsor->name }}</div>
                    <div class="card-block">
                            <div class="row">
                                <div class="col-lg-5 col-md-7 pull-left">
                                    <a href="{{ $sponsor->link }}"><img src="{{ $sponsor->image }}"
                                                                        alt="sponsor-logo"
                                                                        class="sponsor-logo"/></a>
                                </div>
                                <div class="col-lg-7 col-md-5 breaking-word">
                                    <a href="{{ $sponsor->link }}">{{ $sponsor->description }}</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        @endforeach


        <div class="col-md-12 align-center">{{ $sponsors->links() }}</div>
    </div>
</div>