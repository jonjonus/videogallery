@extends('layouts.list')

@section('index-content')
    <!-- Current Tags -->
    <table class="table table-hover tag-table">
        <thead>
            <th>Value</th>
            <th>Type</th>
            <th>Videos</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td class="table-text">
                        <div>
                            <a href="{{ action('TagsController@show', [$tag->id]) }}">{{ $tag->value }}</a>
                        </div>
                    </td>
                    <td class="table-text">
                        <div>{{ $tag->tagtype->name }}</div>
                    </td>
                    <td class="table-text"><div>{{ count($tag->videos) }}</div></td>
                    <td>
                        @include('common.form-delete', ['action' => 'TagsController@destroy', 'id' => $tag->id])
                    </td>
                    <td>
                        @include('common.form-edit', ['action' => 'TagsController@edit', 'id' => $tag->id])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection