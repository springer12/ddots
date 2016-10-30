@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 card">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Students</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@include('helpers.grid-header', ['name' => 'ID',           'order' => 'id'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Name',  'order' => 'name'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'E-mail',  'order' => 'email'])</th>
                                <th>@include('helpers.grid-header', ['name' => 'Nickname',  'order' => 'nickname'])</th>
                                <th>Groups</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($students as $student)
                                <tr data-student-row-id="{{ $student->id }}">
                                    <td>{{ $student->id }}</td>
                                    <td class="wrap-text">{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->nickname }}</td>
                                    <td>
                                        @foreach($student->groups as $group)
                                            {{ $group->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($student->pivot->confirmed == 0)
                                            <a data-confirm data-student-id="{{ $student->id }}"
                                               data-url="{{ route('frontend::ajax::confirmStudent',['id' => $student->id]) }}"
                                               title="Confirm">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </a>
                                            <a data-decline data-student-id="{{ $student->id }}"
                                               data-url="{{ route('frontend::ajax::declineStudent',['id' => $student->id]) }}"
                                               title="Decline">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                        <a data-edit-student-id="{{ $student->id }}" title="Edit" data-toggle="dropdown"
                                                {{ !$student->pivot->confirmed?:'style="display: none;"' }}>
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($groups->diff($student->groups) as $group)
                                                <li role="presentation" data-add-student
                                                    data-url="{{ route('frontend::ajax::addStudentToGroup',['student_id' => $student->id, 'group_id' => $group->id]) }}">
                                                    <a>{{ $group->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="custom-pager">
                            {{ $students->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
