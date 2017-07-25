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




 
