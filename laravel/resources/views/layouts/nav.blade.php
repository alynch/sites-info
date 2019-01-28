<header>
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="padding: 15px 10px">
        <svg width="20px" height="20px" viewBox="0 0 20 20">
            <g transform="translate(-8, -8)">
                <path d="M12,17 L12,15 L14,15 L14,21 L12,21 L12,19 L8,19 L8,17 L12,17 Z M24,10 L28,10 L28,12 L24,12 L24,14 L22,14 L22,8 L24,8 L24,10 Z M17,24 L17,22 L19,22 L19,28 L17,28 L17,26 L8,26 L8,24 L17,24 Z M21,24 L28,24 L28,26 L21,26 L21,24 Z M8,10 L20,10 L20,12 L8,12 L8,10 Z M16,17 L28,17 L28,19 L16,19 L16,17 Z" fill="#999"></path>
            </g>
        </svg>
            &nbsp;&nbsp;
            {{ config('app.name') }}
        </a>
    </div>
</header>

<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                @auth
                    <ul class="navbar-nav mr-auto">
                        <li>
                            <a class="nav-link" href="/environments">Environments</a>
                        </li>
                        <li>
                            <a class="nav-link" href="/application-groups">Application groups</a>
                        </li>
                        <li>
                            <a class="nav-link" href="/applications">Applications</a>
                        </li>
                        <li>
                            <a class="nav-link" href="/units">Academic units</a>
                        </li>
                        <li>
                            <a class="nav-link" href="/timeline">Timeline</a>
                        </li>
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

