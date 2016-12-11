<div class="card-block">
    <div class="row">
        <div class="col-md-4">
            <a href="{{ url('news', ['id' => $news_item->id]) }}">
                <p>{{ $news_item->name }}</p>
            </a>
        </div>
        <div class="col-md-8">
            <p class="breaking-word">{{ str_limit($news_item->stripped_content, 150) }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 offset-md-4">
            {{ $news_item->created_at }}
        </div>
    </div>
</div>
<hr>