<div class="container">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header breaking-word">
                {{ $news_item->name }}
            </div>
            <div class="card-block breaking-word">
                {!! $news_item->content !!}
            </div>
        </div>
    </div>
</div>