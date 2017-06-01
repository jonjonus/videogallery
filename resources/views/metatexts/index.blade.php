@extends('layouts.list')

@section('index-content')
    <!-- Current Metatexts -->
    <table class="table table-hover metatext-table">
        <thead>
            <th>all</th>
            <th>Name</th>
            <th>Videos</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($metatexts as $metatext)
                <tr>
                    <td class="table-text"><div><input type="checkbox" name="select" value="{{ $metatext->id }}"></div></td>
                    <td class="table-text"><div>{{ $metatext->name}}</div></td>
                    <td class="table-text"><div>{{ count($metatext->videos) }}</div></td>
                    <td>
                        @include('common.form-delete', ['action' => 'MetatextsController@destroy', 'id' => $metatext->id])
                    </td>
                    <td>
                        @include('common.form-edit', ['action' => 'MetatextsController@edit', 'id' => $metatext->id])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection