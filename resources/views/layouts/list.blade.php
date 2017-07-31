@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @yield('index-content')
        </div>
    </div>

    @if (isset($moreButtons))
        @include($moreButtons)
    @endif
@endsection