@extends('layouts.app')

@section('content')
    {{ Form::open(['action' => 'YoutubeController@vimeo_create_job']) }}
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <button type="submit" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Asynchronous Vimeo Update</button>
    {{ Form::close() }}
@endsection

@section('scripts')
    <script src="DataTables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
    <script src="DataTables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
@endsection

@section(('stylesheets'))
    <link href="/Datatables/Bootstrap-3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
@endsection

{{--@section('scripts')--}}
    {{--<script src="/js/vimeo.js"></script>--}}
{{--@endsection--}}




 
