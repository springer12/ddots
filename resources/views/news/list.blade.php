<div class="container">
    <div class="row">
        @foreach($news as $news_item)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-block">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="{{ url('news', ['id' => $news_item->id]) }}">{{ $news_item->name }}</a>
                                </div>
                                <div class="col-xs-8 breaking-word">
                                    {{ str_limit($news_item->stripped_content, 60) }}
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