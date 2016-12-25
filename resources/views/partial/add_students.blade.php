<div class="tab-pane fade" role="tabpanel" id="participants"> {{-- @todo --}}
    <div class="card-block">
        <div class="row">
            <div class="col-md-6">
                <select class="form-control" data-participant-select data-placeholder="@lang('contest.select.participants')">
                    <option></option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <select class="form-control" data-group-select data-placeholder="@lang('contest.select.groups')">
                    <option></option>
                    @foreach(Auth::user()->groups as $group)
                        <option data-user-ids="{{ $group->users->pluck('id')->toJson() }}"
                                value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr class="invisible">
    <table class="table table-striped table-bordered table-sm" data-participants
           @foreach($participants as $participant)
           data-{{ $participant->id }}="{{ $participant->name }}"
            @endforeach
    >
        <thead>
        <tr>
            <th>@lang('layout.name')</th>
            <th>@lang('contest.action')</th>
        </tr>
        </thead>
    </table>
</div>