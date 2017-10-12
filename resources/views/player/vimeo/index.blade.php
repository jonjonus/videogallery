@extends('player.vimeo.layout')

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8 col-lg-9 col-video">
        {{--<div class="bg-tilt"></div>--}}
        <div class="embed-responsive embed-responsive-16by9 embed-custom">
            {!! $playlist->videos()->first()->styledEmbed !!}
        </div>
    </div>
    <div class="col-xs-12 col-md-4 col-lg-3">
        <div class="list-group">
            @foreach ($playlist->videos()->get() as $video)
                <a href="#"
                   class="list-group-item"
                   id="{{ $video->id }}"
                   data-cloudid = "{{ $video->cloud_id }}"
                   data-service = "{{ $video->service->name }}"
                   data-embed   = "{{ $video->styledEmbed }}">
                    <div class="row">
                        <div class="col-xs-3 col-wop">
                            <img src="{{ $video->thumbnail_hq }}" alt="{{ $video->title }}" class="img-responsive" />
                        </div>
                        <div class="col-xs-9">
                            <h4 class="list-group-item-heading" style="margin-top: 10px" id="{{ $video->id }}_title">{{ $video->title }}</h4>
                            <div class="list-group-item-text" id="[{{ $video->id }}_description">{{ $video->description }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
            <script src="/js/player_vimeo.js"></script>
@endsection