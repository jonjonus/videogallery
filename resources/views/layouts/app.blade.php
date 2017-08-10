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
    @yield('variables')
    @yield('scripts')
    @yield('modals')
    <script>
        var csrf = '{{ csrf_token() }}';
        $(function () {
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : csrf } });
        });
    </script>
</body>
</html>
