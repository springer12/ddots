<?php
$users_count_who_try_to_solve = [];
$users_count_who_solved = [];
?>
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
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($results as $result)
            <tr>
                <td>
                    {{ $i++ }}
                </td>
                <td>
                    @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER) && Auth::user()->isTeacherOf($result['user']->id) || Auth::user()->id == $result['user']->id)
                        <a href="{{ route('frontend::user::profile', ['id' => $result['user']->id]) }}">
                            {{ $result['user']->name }}
                        </a>
                    @else
                        {{ $result['user']->name }}
                    @endif
                </td>
                @foreach($result['solutions'] as $solution)
                    <td>
                        @if(isset($solution))
                            @if(Auth::user()->hasRole(\App\User::ROLE_TEACHER))
                                <a href="{{ route('frontend::contests::solution', ['id' => $solution->id]) }}">
                                    {{ number_format($solution->success_percentage / 100 * $contest->getProblemMaxPoints($solution->problem_id), 2, '.', '') }}
                                </a>
                            @else
                                {{ number_format($solution->success_percentage / 100 * $contest->getProblemMaxPoints($solution->problem_id), 2, '.', '') }}
                            @endif

                            <?php
                            isset($users_count_who_solved[$solution->problem_id]) ?: $users_count_who_solved[$solution->problem_id] = 0;
                            if ($solution->status == \App\Solution::STATUS_OK) {
                                $users_count_who_solved[$solution->problem_id]++;
                            }
                            ?>
                        @endif
                    </td>
                @endforeach
                <td>
                    {{ number_format($result['total'], 2, '.', '') }}
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">@lang('contest.average_points')</th>
            @foreach($contest->problems as $problem)
                <td>{{ number_format($totals['avg_by_problems'][$problem->id], 2, '.', '') }}</td>
            @endforeach
            <th>{{ number_format($totals['total_avg'], 2, '.', '')  }}</th>
        </tr>
        <tr>
            <th colspan="2">@lang('contest.attempts')</th>
            @foreach($contest->problems as $problem)
                <td>{{ $users_count_who_try_to_solve[$problem->id] = $problem->getUsersWhoTryToSolve($contest) }}</td>
            @endforeach
            <th>{{ $contest->getUsersWhoTryToSolve() }}</th>
        </tr>
        <tr>
            <th colspan="2">@lang('contest.solved')</th>
            @foreach($contest->problems as $problem)
                <td>
                    {{ $users_count_who_solved[$problem->id] = $problem->getUsersWhoSolved($contest) }}
                    @if($users_count_who_solved[$problem->id])
                        ({{ round($users_count_who_solved[$problem->id] / $users_count_who_try_to_solve[$problem->id] * 100) }}
                        %)
                    @endif
                </td>
            @endforeach
            <th>{{ $contest->getUsersWhoSolved() }}</th>
        </tr>
        </tfoot>
    </table>
</div>