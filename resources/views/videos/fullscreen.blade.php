@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 no-float">
                {!! $iframe !!}
            </div>
        </div>
    </div>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="/css/fullscreen.css">
@endsection