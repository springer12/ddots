<div class="table-responsive">
    <table class="table table-striped table-bordered table-sm">
        <thead>
        <tr>
            <th>@lang('contest.position')</th>
            <th>@lang('contest.user')</th>
            @foreach($problems as $problem)
                <th>
                    <a href="{{ $problem->getLink($contest) }}">{{ $problem->name }}</a>
                </th>
            @endforeach
            <th>@lang('contest.total')</th>
            <th>@lang('contest.time')</th>
            <th>@lang('contest.incorrect_solutions_percentage')</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($results as $result)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @if(Auth::user()->isTeacherOf($result['user']->id) || Auth::user()->id == $result['user']->id)
                        <a href="{{ route('frontend::user::profile', ['id' => $result['user']->id]) }}">{{ $result['user']->name }}</a>
                    @else
                        {{ $result['user']->name }}
                    @endif
                </td>
                @foreach($problems as $problem)
                    <td>
                        @if(isset($result[$problem->id]))
                            @if(isset($result[$problem->id]['solution_id']) && Auth::user()->hasRole(App\User::ROLE_TEACHER || Auth::user()->id == $result['user']->id))
                                <a href="{{ route('frontend::contests::solution', ['id' => $result[$problem->id]['solution_id']]) }}">
                                    @endif
                                    <div class="col-xs-12">
                                        {{ $result[$problem->id]['solved'] ? '+' : '-' }}{{ $result[$problem->id]['attempts'] > 1 ? $result[$problem->id]['attempts'] - 1 : '' }}
                                    </div>
                                    <div class="col-xs-12">
                                        <?php
                                        $hours = (int)($result[$problem->id]['time'] / 60);
                                        $minutes = $result[$problem->id]['time'] - $hours * 60;
                                        ?>
                                        {{ $hours }}:{{ str_pad($minutes, 2, 0, STR_PAD_LEFT) }}
                                    </div>
                                    @if(isset($result[$problem->id]['solution_id']) && Auth::user()->hasRole(App\User::ROLE_TEACHER || Auth::user()->id == $result['user']->id))
                                </a>
                            @endif
                        @endif
                    </td>
                @endforeach
                <td>{{ $result['total'] }}</td>
                <?php
                $hours = (int)($result['time'] / 60);
                $minutes = $result['time'] - $hours * 60;
                ?>
                <td>{{ $hours }}:{{ str_pad($minutes, 2, 0, STR_PAD_LEFT) }}</td>
                <td>{{ (int)$result['error_percentage'] }}%</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">@lang('contest.results')</th>
            @foreach($problems as $problem)
                <th>
                    <a href="{{ $problem->getLink($contest) }}">{{ $problem->name }}</a>
                </th>
            @endforeach
            <th colspan="3">@lang('contest.total')</th>
        </tr>
        <tr>
            <th colspan="2">@lang('contest.users_attempted')</th>
            @foreach($problems as $problem)
                <td>{{ $totals[$problem->id]['users_attempted'] }}</td>
            @endforeach
            <td colspan="3">{{ $totals['users_attempted'] }}</td>
        </tr>
        <tr>
            <th colspan="2">@lang('contest.users_solved')</th>
            @foreach($problems as $problem)
                <td>{{ $totals[$problem->id]['correct_solutions'] }}</td>
            @endforeach
            <td colspan="3">{{ $totals['correct_solutions'] }}</td>
        </tr>
        <tr>
            <th colspan="2">@lang('contest.solutions_sent')</th>
            @foreach($problems as $problem)
                <td>{{ $totals[$problem->id]['attempts'] }}</td>
            @endforeach
            <td colspan="3">{{ $totals['attempts'] }}</td>
        </tr>
        @foreach(\app\Solution::getStatusDescriptions() as $status => $description)
            <tr>
                <td colspan="2">
                    <div class="col-xs-12">{{ $status }}</div>
                    <div class="col-xs-12">{{ $description }}</div>
                </td>
                @foreach($problems as $problem)
                    <td>
                        <div class="col-xs-12">{{ $totals[$problem->id]['statuses'][$status]['count'] }}</div>
                        <div class="col-xs-12">{{ number_format($totals[$problem->id]['statuses'][$status]['percentage'], 1) }}
                            %
                        </div>
                    </td>
                @endforeach
                <td colspan="3">
                    <div class="col-xs-12">{{ $totals['statuses'][$status]['count'] }}</div>
                    <div class="col-xs-12">{{ number_format($totals['statuses'][$status]['percentage'],1) }}%</div>
                </td>
            </tr>
        @endforeach
        </tfoot>
    </table>
</div>