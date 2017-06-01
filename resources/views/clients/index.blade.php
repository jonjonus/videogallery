@extends('layouts.list')

@section('index-content')
<!-- Current Clients -->
<table class="table table-hover client-table">
    <thead>
        <th>all</th>
        <th>Name</th>
        <th>Videos</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <td class="table-text"><div><input type="checkbox" name="select" value="{{ $client->id }}"></div></td>
                <td class="table-text"><div>{{ $client->name}}</div></td>
                <td class="table-text"><div>{{ count($client->videos) }}</div></td>
                <td>
                    @include('common.form-delete', ['action' => 'ClientsController@destroy', 'id' => $client->id])
                </td>
                <td>
                    @include('common.form-edit', ['action' => 'ClientsController@edit', 'id' => $client->id])
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection