@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $discipline->name }}
                <div class="btn-group float-xs-right">
                    <a class="btn btn-secondary "
                       href="{{ route('teacherOnly::disciplines::add') }}">@lang('contest.create')</a>
                    <a class="btn btn-secondary " title="@lang('layout.edit')"
                       href="{{ action('DisciplineController@showForm', ['id'=> $discipline->id]) }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        @lang('menu.contests')
                    </div>
                    <div class="card-body">todo</div>
                </div>
            </div>

            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        @lang('menu.students')
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr>
                                    <?php $helper_postfix = 'students'; ?>
                                    <th>@include('helpers.grid-header', ['name' => trans('layout.id'), 'order' => 'id'])</th>
                                    <th>@include('helpers.grid-header', ['name' => trans('layout.name'),  'order' => 'name'])</th>
                                    <th>@include('helpers.grid-header', ['name' => trans('layout.email'),  'order' => 'email'])</th>
                                    <th>@include('helpers.grid-header', ['name' => trans('layout.nickname'),  'order' => 'nickname'])</th>
                                    <th>@lang('menu.groups')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr data-student-row-id="{{ $student->id }}">
                                        <td>{{ $student->id }}</td>
                                        <td class="wrap-text"><a
                                                    href="{{  route('frontend::user::profile', ['id' => $student->id]) }}">{{ $student->name }}</a>
                                        </td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->nickname }}</td>
                                        <td>
                                            @foreach($student->groups as $group)
                                                {{ $group->name }}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="align-center">
                                {{ $students->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-block">
                <div class="card">
                    <div class="card-header">
                        @lang('menu.problems')
                    </div>
                    <div class="card-body">
                        <?php $helper_postfix = 'problems'; ?>
                        @include('partial.problems_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
