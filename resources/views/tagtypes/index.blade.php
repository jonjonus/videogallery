@extends('layouts.list')

@section('index-content')
    <!-- Current Videos -->
    <table class="table table-hover tagtype-table">
        <thead>
            <th>all</th>
            <th>Name</th>
            <th>Tags</th>
            <th>Videos</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($tagtypes as $tagtype)
                <tr>
                    <td class="table-text"><div><input type="checkbox" name="select" value="{{ $tagtype->id }}"></div></td>
                    <td class="table-text"><div>{{ $tagtype->name }}</div></td>
                    <td class="table-text"><div>{{ count($tagtype->tags) }}</div></td>
                    <td class="table-text"><div>{{ count($tagtype->tags) }}</div></td>
                    
                    {{--
                    <td class="table-text"><div>{{ count($tagtype->tags) }}</div></td>
                    <td class="table-text"><div>{{ count($tagtype->tags->videos) }}</div></td>
                    --}}
                    <td>
                        @include('common.form-delete', ['action' => 'TagtypesController@destroy', 'id' => $tagtype->id])
                    </td>
                    <td>
                        @include('common.form-edit', ['action' => 'TagtypesController@edit', 'id' => $tagtype->id])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection