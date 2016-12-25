
    <div class="card-block">
        <div class="row">
            <div class="col-md-6">
                <select data-problem-select
                        data-placeholder="@lang('contest.select.problems')"
                        data-get-problems-url="{{ route('privileged::ajax::searchProblems') }}"
                        class="form-control col-md-7 col-xs-12">
                    <option></option>
                </select>
            </div>
            <div class="col-md-6">
                <select data-volume-select
                        data-placeholder="@lang('contest.select.volumes')"
                        data-get-volumes-url="{{ route('privileged::ajax::searchVolumes') }}"
                        class="form-control col-md-7 col-xs-12">
                    <option></option>
                </select>
            </div>
        </div>
    </div>