@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="card">
                <div class="card-header">@lang('menu.students')</div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID', 'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'E-mail',  'order' => 'email'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Nickname',  'order' => 'nickname'])</th>
                                <th>@lang('menu.groups')</th>
                                <th>@lang('layout.actions')</th>
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

                                    <td class="{{ $student->pivot->confirmed?:'actions-menu  btn-group' }}">
                                        @if($student->pivot->confirmed == 0)
                                            <a class="btn btn-secondary" data-confirm
                                               data-student-id="{{ $student->id }}"
                                               data-url="{{ route('frontend::ajax::confirmStudent',['id' => $student->id]) }}"
                                               title="Confirm">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>
                                            <a class="btn btn-danger" data-decline data-student-id="{{ $student->id }}"
                                               href="javascript:void(0);"
                                               data-url="{{ route('frontend::ajax::declineStudent',['id' => $student->id]) }}"
                                               title="Decline">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        @endif
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
    </div>
@endsection
