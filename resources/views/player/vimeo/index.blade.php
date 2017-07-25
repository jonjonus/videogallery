@extends('player.vimeo.layout')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-9 player">
        {!! $playlist->videos()->first()->embed !!}
    </div>
    <div class="col-sm-12 col-md-4 col-lg-3">
        @foreach ($playlist->videos()->get() as $video)
            <a href="#"
               class="list-group-item"
               id="{{ $video->id }}"
               data-cloudid = "{{ $video->cloud_id }}"
               data-service = "{{ $video->service->name }}"
               data-embed   = "{{ $video->embed }}">
                <div class="col-sm-3" style="padding: 0px;"><img style="max-height: 100%; max-width: 100%;" src="{{ $video->thumbnail_hq }}" alt="{{ $video->title }}" /></div>
                <div class="col-sm-9">
                    <h4 class="list-group-item-heading" style="margin-top: 10px" id="{{ $video->id }}_title">{{ $video->title }}</h4>
                    <div style="display: none" class="list-group-item-text" id="[{{ $video->id }}_description">{{ $video->description }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
            <script src="/js/player_vimeo.js"></script>
@endsection