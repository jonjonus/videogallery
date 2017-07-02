@extends('layouts.app')

@section('content')


    {{ Form::open(['action' => 'YoutubeController@vimeo_index']) }}
    {{ csrf_field() }}
    {{ method_field('POST') }}
    @if ($job)
        Vimeo Update Job created at: {{ date('D, F j Y, h:i:s A', $job->created_at) }}
    @else
        <button type="submit" class="btn btn-primary btn-lg" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Updating...">Asyncronous Vimeo Update</button>
    @endif
    {{ Form::close() }}
<ul id="videos"></ul>
<table id="response"></table>
@endsection

{{--@section('scripts')--}}
    {{--<script src="/js/vimeo.js"></script>--}}
{{--@endsection--}}




 
