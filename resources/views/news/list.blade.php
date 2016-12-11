<div class="container">
    <div class="row">
        @foreach($news as $news_item)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ $news_item->name }}</div>
                    <div class="card-block">
                        <div class="container">
                            <div class="row">
                                <div class="breaking-word">
                                    <p class="indent"><a href="{{ url('news', ['id' => $news_item->id]) }}">{{ str_limit($news_item->stripped_content, 255) }}</a></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 offset-md-4">
                                    {{ $news_item->created_at }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12 align-center">{{ $news->links() }}</div>
    </div>
</div>