<div class="row">
    <div class="col-md-10 col-sm-10 col-xs-10">
        <form class="form-inline" role="form" action="{{ $action }}" method="GET">
            <div class="input-group">
                <input type="text" class="search-query form-control" placeholder="Search" name="query" value="{{ $query }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" id="search">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    @if ($query)
        <div class="col-md-2 col-sm-2 col-xs-2">
            <a class="btn btn-primary" href="{{ $action }}" role="button">Reset</a>
        </div>
    @endif
</div>

