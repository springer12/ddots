<div class="table-responsive">
    <table class="table table-striped table-bordered table-sm">
        <thead>
        <tr>
            <th>@include('helpers.grid-header', ['name' => trans('layout.name'),  'order' => 'name'])</th>
            <th>@lang('layout.volume')</th>
            <th>@include('helpers.grid-header', ['name' => trans('contest.difficulty'), 'order' => 'difficulty'])</th>
        </tr>
        </thead>
        <tbody>
        @foreach($problems as $problem)
            <tr>
                <td class="wrap-text">
                    <a href="{{ action('ProblemController@single', ['id' => $problem->id]) }}">{{ $problem->name }}</a>
                </td>
                <?php $str = ''; ?>
                @foreach($problem->volumes as $volume)
                    <?php $str .= $volume->name ?>
                @endforeach
                <td title="{{ $str }}">
                    {{ str_limit($str, 25) }}
                </td>
                <td>
                    @for($i = 0; $i < $problem->difficulty; $i++)
                        <i class="fa fa-star" aria-hidden="true"></i>
                    @endfor
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="align-center">
        {{ $problems->links() }}
    </div>
</div>