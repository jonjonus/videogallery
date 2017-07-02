<nav id="nav-menu" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Video Gallery
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">File <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ action('VideosController@index') }}"        >Videos</a></li>
                        <li><a href="{{ action('PlaylistsController@index') }}"     >Playlists</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ action('ClientsController@index') }}"       >Clients</a></li>
                        <li><a href="{{ action('MetatextsController@index') }}"     >Metatexts</a></li>
                        <li><a href="{{ action('TagsController@index') }}"          >Tags</a></li>
                        <li><a href="{{ action('TagtypesController@index') }}"      >Tag Types</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ action('YoutubeController@youtube_index') }}">Update Youtube videos</a></li>
                        <li><a href="{{ action('YoutubeController@vimeo_index') }}">Update Vimeo videos</a></li>

                    </ul>
                </li>
                <li>
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    {{-- TODO hide these lines to disable registration --}}
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
