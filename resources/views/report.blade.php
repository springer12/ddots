@if($_GET['pass'] == 'ASPFNSAGASUG')

    Админка : root / geRayay8 <br>
    Баги <a href="https://github.com/valik351/ddots/issues/new">сюда =)</a>

    <br>
    <br>
    <br>

    Не оплачено: {{ \DB::select("select sum(minutes) as minutes from work_time_reports where paid=0")[0]->minutes * 0.1 }} $<br>
    Оплачено: {{ \DB::select("select sum(minutes) as minutes from work_time_reports where paid=1")[0]->minutes * 0.1 }} $<br>
    <table>
        <tr>
            <th>Дата</th>
            <th>Время</th>
            <th>Деньги</th>
            <th>Описание</th>
        </tr>
        @foreach(\DB::select("select * from work_time_reports order by `when` desc") as $report)
            <tr style="color: white; {{ $report->paid ? 'background-color:#5cb85c' : 'background-color:#d9534f' }}">
                <td>{{ $report->when }}</td>
                <td>{{ $report->minutes }} min</td>
                <td>{{ $report->minutes * 0.1 }} $</td>
                <td>{{ $report->desc }}</td>
            </tr>
        @endforeach
    </table>
@endif