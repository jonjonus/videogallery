<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Video Gallery</title>

    <!-- Styles -->
    {{-- 0. Bootstrap--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    @yield('stylesheets')
</head>
<body id="app-layout">
    @include('common.navbar')
    <div class="alert alert-warning alert-dismissible" role="alert" style="display: none;">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      All <strong>count</strong> videos on this page are selected. <a href="#" class="alert-link">Click here to select all <strong>count</strong> videos.</a>
    </div>
    
   @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    {{-- 0. Bootstrap--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    @yield('variables')
    @yield('scripts')
    @yield('modals')
    <script>
        var csrf = '{{ csrf_token() }}';
    </script>
    <script src="/js/app.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
