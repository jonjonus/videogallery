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

@section('scripts')
    <script src="DataTables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
    <script src="DataTables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
@endsection

@section(('stylesheets'))
    <link href="/Datatables/Bootstrap-3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
@endsection