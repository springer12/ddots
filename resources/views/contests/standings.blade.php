<?php
$users_count_who_try_to_solve = [];
$users_count_who_solved = [];
?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('frontend::contests::single', ['id' => $contest->id]) }}">{{ $contest->name }}</a>
                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                Standings
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>Position</th>
                            <th>User</th>
                            @foreach($problems as $problem)
                                <th>
                                    <a href="{{ $problem->getLink($contest) }}">{{ $problem->name }}</a>
                                </th>
                            @endforeach
                            <th>Total</th>
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
                                            if($solution->status == \App\Solution::STATUS_OK) {
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
                            <th colspan="2">Average points</th>
                            @foreach($contest->problems as $problem)
                                <td>{{ number_format($totals['avg_by_problems'][$problem->id], 2, '.', '') }}</td>
                            @endforeach
                            <th>{{ number_format($totals['total_avg'], 2, '.', '')  }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Attempts</th>
                            @foreach($contest->problems as $problem)
                                <td>{{ $users_count_who_try_to_solve[$problem->id] = $problem->getUsersWhoTryToSolve($contest) }}</td>
                            @endforeach
                            <th>{{ $contest->getUsersWhoTryToSolve() }}</th>
                        </tr>
                        <tr>
                            <th colspan="2">Solved</th>
                            @foreach($contest->problems as $problem)
                                <td>
                                    @if($contest->show_max)
                                        {{ $users_count_who_solved[$problem->id] = $problem->getUsersWhoSolved($contest) }}
                                        @if($users_count_who_solved[$problem->id])
                                            ({{ round($users_count_who_solved[$problem->id] / $users_count_who_try_to_solve[$problem->id] * 100) }}%)
                                        @endif
                                    @else
                                        {{ $users_count_who_solved[$problem->id] }}
                                        @if($users_count_who_solved[$problem->id])
                                            ({{ round($users_count_who_solved[$problem->id] / $users_count_who_try_to_solve[$problem->id] * 100) }}%)
                                        @endif
                                    @endif
                                </td>
                            @endforeach
                            <th>{{ $contest->getUsersWhoSolved() }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
