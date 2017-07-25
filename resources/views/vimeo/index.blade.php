@extends('layouts.app')

@section('content')
    {{ Form::open(['action' => 'YoutubeController@vimeo_create_job']) }}
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <button type="submit" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Asynchronous Vimeo Update</button>
    {{ Form::close() }}
@endsection

{{--@section('scripts')--}}
    {{--<script src="/js/vimeo.js"></script>--}}
{{--@endsection--}}




 
