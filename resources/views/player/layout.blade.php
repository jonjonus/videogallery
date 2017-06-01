<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/favicon.ico">
        <title>{{ $playlist->title }}</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"><link rel="stylesheet" href="/css/player.css">
    </head>

    <body role="document">
        @if($alert)
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Heads-up!</strong> You are looking at a password protected playlist.
        </div>
        @endif
        <div class="header">
            <div class="col-md-6 logo">
                <a href="http://creativa.com.au/"><img src="/imgs/creativa.png"></a>
            </div>
            <div class="col-md-6 info">
                <a href="mailto:hello@creativa.com.au"><img src="/imgs/at.png"> hello@creativa.com.au</a>
                <a href="http://creativa.com.au/"><img src="/imgs/tag.png"> 207 Glen Huntly Road, Elsternwick 3185</a>
            </div>
        </div>
        <div class="container-fluid" role="main">
            @yield('content')
        </div> <!-- /container -->
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- <script>window.jQuery || document.write('<script src="vendor/twbs/bootstrap/docs/assets/js/vendor/jquery.min.js"><\/script>')</script> -->
    @yield('scripts')



    </body>
</html>
