<nav class="navbar navbar-expand-md navbar-light navbar-laravel Regular shadow">

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto d-flex align-items-center">


                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item {{ request()->segment(1) == 'departments' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('departments.index') }}">Department</a>
                    </li>

                    <li class="nav-item {{ request()->segment(1) == 'positions' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('positions.index') }}">Positions</a>
                    </li>

                    <li class="nav-item {{ request()->segment(1) == 'users' || request()->segment(1) == null ? 'active' : '' }}">
                        <a class="nav-link align-middle" href="{{ route('users.index') }}">Users Management</a>
                    </li>

                    <li class="nav-item dropdown align-middle">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{-- {{ auth()->user()->name }} --}}
                            {{ auth()->user()->name }}
                            <img src="{{ '/assets/images/users/' . auth()->user()->profile }}" alt="AppDev Team" class="img-profile rounded-circle mr-2">
                        </a>
                        <div class="dropdown-menu text-center" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item " href="{{ route('profile') }}">
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>

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
