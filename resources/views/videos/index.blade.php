@extends('layouts.list-with-panel')

@section('index-content')
    <div class="img-overlay"><img src="/imgs/creativa.png"></div>
    <div>Selected videos: <span id="videos-count"></span></div>
    <!-- Current Videos -->
    {{--<table id="datatable" class="table table-hover table-bordered table-condensed">--}}
    <table id="datatable" class="table table-striped table-bordered" cellspacing="0">
        <thead>
        <tr>
            {{-- 0 --}}<th>Select</th>
            {{-- 1 --}}<th>Thumbnail</th>
            {{-- 2 --}}<th></th> {{-- Actions --}}
            {{-- 3 --}}<th>Title</th>
            {{-- 4 --}}<th>Duration</th>
            {{-- 5 --}}<th>Description</th>
            {{-- 6 --}}<th>Produced</th>
            {{-- 7 --}}<th>Client</th>
            {{-- 8 --}}<th>Name</th>
            {{-- 9 --}}<th>New</th>     <?php $pos_new_column   = 8;                               ?> {{-- NOTE: if columns added or removed UPDATE this number! --}}
            {{-- 10--}}<th>Ignore</th> <?php $pos_ignore_column = 9;                               ?> {{-- NOTE: if columns added or removed UPDATE this number! --}}
            {{-- 11--}}<th>Meta</th>    <?php $pos_meta_column  = 11; ?> {{-- NOTE: if columns added or removed UPDATE this number! --}}
            {{-- 12--}} <?php $pos_first_tags_column = 12; ?>
            @foreach ($tagTypes as $tagType)
                <th>{{ $tagType->name }}</th>
            @endforeach
            <th>Service</th>
        </tr>
        <tr>
            <td></td> {{-- Select --}}
            <td></td> {{-- Thumbnail --}}
            <td></td> {{-- Actions --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Title --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Duration --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Description --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Produced --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Client --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Name --}}
            <td></td>{{-- New --}}
            <td></td>{{-- Ignore --}}
            <td><input class="search-box" type="text" placeholder="Search"></td>{{-- Meta --}}
            @foreach ($tagTypes as $tagType)
                <td><input class="search-box" type="text" placeholder="Search"></td>
            @endforeach
            <td></td>
        </tr>
        </thead>
    </table>

    <style>
        div.selectize-dropdown {
            z-index: 2001; }
    </style>
@endsection

@section('stylesheets')
    {{-- CDN Option --}}
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.15/af-2.2.0/b-1.3.1/b-colvis-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/sc-1.4.2/se-1.2.2/datatables.min.css"/>--}}

    {{-- Local Option--}}
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>



@endsection

@section('scripts')
    {{-- CDN Option --}}
    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.15/b-1.3.1/b-colvis-1.3.1/cr-1.3.3/fc-3.2.2/fh-3.1.2/kt-2.2.1/r-2.1.1/sc-1.4.2/se-1.2.2/datatables.min.js"></script>--}}
    {{-- Local Option--}}
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="Editor-PHP-1.6.2/js/dataTables.editor.min.js"></script>

    {{--App--}}
    <script type="text/javascript" src="/js/datatable.js"></script>

@endsection

@section('variables')
    <script>
        var clients           = {!! json_encode($clients)  !!};
        var tagTypes          = {!! json_encode($tagTypes) !!};
        var CSRF_TOKEN        = '{{ csrf_token() }}';
        var pos_new_column    =  <?php echo $pos_new_column; ?>;
        var pos_ignore_column =  <?php echo $pos_ignore_column; ?>;
        var pos_meta_column   =  <?php echo $pos_meta_column; ?>;
    </script>
@endsection

@section('modals')
    @include('common.modal')
@endsection