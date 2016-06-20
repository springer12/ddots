@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="container">
                    <h2>Testing Servers</h2>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Server name</th>
                            <th>Auth key</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($servers as $server)
                            <tr>
                                <td>{{ $server->id }}</td>
                                <td>{{ $server->name }}</td>
                                <td>{{ $server->auth_key }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $servers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
