<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
    <a class="navbar-brand" href="#">Expat Dakar Food</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavDropdown">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="nav-link font-weight-bold" data-toggle="modal" data-target="#cartModal">
                    <i class="fas fa-pizza-slice"></i>
                    Ma commande
                    <span class="badge badge-pill badge-danger">
                    {{ auth()->user()->getDailyOrder() && auth()->user()->getDailyOrder()->items ? auth()->user()->getDailyOrder()->items->count() : 0 }}
                    </span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{__('login')}}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i> {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('profile') }}</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
        </ul>
    </div>
    </nav>