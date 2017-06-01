@extends('layouts.app')

@section('content')
    Total <span id="total"></span>
    <br>
    Page <span id="page">{{$page_token}}</span>
    {{ Form::open(['action' => 'YoutubeController@vimeo_clear']) }}
    {{ csrf_field() }}
    {{ method_field('GET') }}
    <button type="submit" class="btn btn-primary btn-lg vimeo-clear" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Restarting...">Clear Vimeo Update</button>
    {{ Form::close() }}

    {{ Form::open(['action' => 'YoutubeController@vimeo_update']) }}
    {{ csrf_field() }}
    {{ method_field('GET') }}
    <button type="submit" class="btn btn-primary btn-lg vimeo-load" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Start Vimeo Update</button>
    {{ Form::close() }}
<ul id="videos"></ul>
<table id="response"></table>
@endsection

@section('scripts')
    <script src="/js/vimeo.js"></script>
@endsection




 
