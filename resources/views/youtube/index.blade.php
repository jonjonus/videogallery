@extends('layouts.app')

@section('content')
    Page token: {{ $page_token }}
    {{ Form::open(['action' => 'YoutubeController@youtube_clear']) }}
    {{ csrf_field() }}
    {{ method_field('GET') }}
    <button type="submit" class="btn btn-primary btn-lg " id="clear" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Restarting...">Clear Youtube Update</button>
    {{ Form::close() }}

    {{ Form::open(['action' => 'YoutubeController@youtube_update']) }}
    {{ csrf_field() }}
    {{ method_field('GET') }}
    <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Start Youtube Update</button>
    {{ Form::close() }}
<ul id="videos"></ul>
<table id="response"></table>
@endsection


@section('scripts')
    <script src="DataTables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
    <script src="DataTables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/youtube.js"></script>
@endsection

@section(('stylesheets'))
    <link href="/Datatables/Bootstrap-3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
@endsection




 
