<header>
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" style="padding: 15px 10px">
            <svg width="0" height="0" viewbox="0 0 32 32">
                <g style="fill:none; stroke:#ccc; stroke-width:4; stroke-linecap:round; stroke-linejoin: round">
                <circle cx="16" cy="16" r="12"/>
                <path d="M16 16 L0 16"/>
                </g>
            </svg>
            <svg width="32" height="32" viewbox="0 0 32 32">
                <g style="fill:none; stroke:#ccc; stroke-width:4; stroke-linecap:round; stroke-linejoin: round">
                <path d="M2 6 l 28 0"/>
                <path d="M2 16 l 28 0"/>
                <path d="M2 26 l 28 0"/>
                </g>
                <g style="fill:#fff; stroke:#ccc; stroke-width:1.5">
                <circle cx="8" cy="6" r="3.5"/>
                <circle cx="18" cy="16" r="3.5"/>
                <circle cx="26" cy="26" r="3.5"/>
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

