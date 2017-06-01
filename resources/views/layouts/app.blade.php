                    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Video Gallery</title>

    <!-- Fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    {{-- 0. Bootstrap--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    {{-- 1. Datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
    {{-- 2. Select 2 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    {{-- 3. Dragula --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css">
    {{-- 4. SweetAlert --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    {{-- Others --}}
    <link rel="stylesheet" href="/css/app.css">
    @yield('stylesheets')
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body id="app-layout">
    @include('common.navbar')
    <div class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      All <strong>count</strong> videos on this page are selected. <a href="#" class="alert-link">Click here to select all <strong>count</strong> videos.</a>
    </div>
    
    <div class="container-fluid">
        <!-- Display Errors -->
        <div class="row">
            @include('common.errors')
        </div> <!-- end row -->
        <!-- Display Warnings-->
        <div class="row">
            @include('common.messages')
        </div> <!-- end row -->
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    {{-- 0. Bootstrap--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    {{-- 1. Datepicker --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
    {{-- 2. Select 2 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{-- 3. Dragula --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
    {{-- 4. SweetAlert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    {{-- Others --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.4/tinymce.jquery.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.4/jquery.tinymce.min.js"></script>--}}
    <script>
        $(function () {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
        });
    </script>
    @yield('variables')
    @yield('scripts')
    @yield('modals')
    {{--<script src="/js/app.js"></script>--}}
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
