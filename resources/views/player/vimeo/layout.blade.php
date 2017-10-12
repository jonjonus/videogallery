<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <title>{{ $playlist->title }}</title>
    <!-- Bootstrap -->
    {{--<link href="css/bootstrap.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="/css/player/vimeo.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">--}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <a class="navbar-brand" href="http://creativa.com.au/"><img src="/imgs/Logo_130x50.png"></a>
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://creativa.com.au/">
                <img alt="Brand" src="/imgs/Logo_130x50.png">
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="nav navbar-nav navbar-right">
                <a href="mailto:hello@creativa.com.au" class="navbar-link"><img src="/imgs/at.png"> hello@creativa.com.au</a>
                <a href="http://creativa.com.au/" class="navbar-link"><img src="/imgs/tag.png"> 207 Glen Huntly Road, Elsternwick 3185</a>
            </div>
        </div>

    </div>
</nav>
{{--<nav class="navbar navbar-default navbar-static-top">--}}
    {{--<div class="container-fluid">--}}
        {{--<div class="navbar-header">--}}
            {{--<a class="navbar-brand" href="http://creativa.com.au/"><img src="/imgs/Logo_130x50.png"></a>--}}
        {{--</div>--}}
        {{--<p class="navbar-text navbar-right">--}}
            {{----}}
        {{--</p>--}}
        {{--<p class="navbar-text navbar-right">--}}
        {{--</p>--}}
    {{--</div>--}}
{{--</nav>--}}
@if($alert)
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Heads-up!</strong> You are looking at a password protected playlist.
    </div>
@endif

<div class="container-fluid">
    <h1 class="title">{{ $playlist->title }}</h1>
    <h2 class="description">{{ $playlist->description }}</h2>
    @yield('content')
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
{{--<script src="js/bootstrap.min.js"></script>--}}

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>