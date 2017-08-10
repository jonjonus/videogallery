@extends('layouts.app')

@section('content')
    <b>Vimeo Update Job created at:</b> {{ date('D, F j Y, h:i:s A', $job->created_at) }}, <b>{{ $ago }}</b>.
@endsection

@section('scripts')
<script>
    setTimeout(function(){
        window.location.reload(1);
    }, 5000);
</script>
@endsection

@section('scripts')
    <script src="DataTables/jQuery-2.2.4/jquery-2.2.4.min.js"></script>
    <script src="DataTables/Bootstrap-3.3.7/js/bootstrap.min.js"></script>
@endsection

@section(('stylesheets'))
    <link href="/DataTables/Bootstrap-3.3.7/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
@endsection


 
