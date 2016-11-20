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
            <th>Time</th>
            <th>Incorrect solutions %</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($results as $result)

            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $result['user']->name }}</td>
                @foreach($problems as $problem)
                    <td>
                        @if(isset($result[$problem->id]))
                            {{ $result[$problem->id]['solved'] ? '+' : '-' }}
                            {{ $result[$problem->id]['attempts'] > 1 ? $result[$problem->id]['attempts'] - 1 : '' }}
                        @endif
                    </td>
                @endforeach
                <td>{{ $result['total'] }}</td>
                <td>{{ $result['time'] }}{{-- @todo: time --}}</td>
                <td>{{ (int)$result['error_percentage'] }}%</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>