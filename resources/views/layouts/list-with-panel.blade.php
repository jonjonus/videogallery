@extends('layouts.app')

@section('content')

    <div class="row" id="row-playlist">
        <div class="col-xs-10">
            @yield('index-content')
        </div>
        <div id="panel-container" class="col-xs-2">
            @include('playlists.panel')
        </div>
    </div>
    @if (isset($moreButtons))
    	@include($moreButtons)
    @endif
@endsection