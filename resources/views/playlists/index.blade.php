@extends('layouts.list')

@section('index-content')
    <!-- Current Playlists -->
    <table class="table table-responsive table-hover playlist-table">
        <thead>
            <th>Select</th>
            <th>Title</th>
            <th>Url</th>
            <th>Pattern</th>
            <th>Created</th>
            <th>Updated</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($playlists as $playlist)
                <tr>
                    <td class="table-text"><div><input type="checkbox" name="select" value="{{ $playlist->id }}"></div></td>
                    <td class="table-text">
                        <div>
                            <a href="{{ action('PlaylistsController@show', [$playlist->id]) }}">{{ $playlist->title }}</a>
                        </div>
                    </td>
                    <td class="table-text"><div><a href="{{ $playlist->url }}" target="_blank">{{ $playlist->url }}</a></div></td>
                    <td class="table-text"><div>{{ $playlist->patern }}</div></td>
                    <td class="table-text"><div class="text-small">{{ $playlist->created_at->format('Y-m-d')}}</div></td>
                    <td class="table-text"><div class="text-small">{{ $playlist->updated_at->format('Y-m-d')}}</div></td>
                    <td>
                        @include('common.form-delete',  ['action' => 'PlaylistsController@destroy', 'id' => $playlist->id])
                        @include('common.form-edit',    ['action' => 'PlaylistsController@edit', 'id' => $playlist->id])
                        @include('playlists.form-load', ['action' => 'PlaylistsController@load', 'id' => $playlist->id])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $playlists->links() !!}
@endsection