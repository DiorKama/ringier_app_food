<div class="sidebar col-md-4 bg-light d-flex flex-column align-items-center py-4">
    @if($menu && $menu->closing_date && $remainingSeconds > 0)
        <!-- Afficher le timer -->
        <div class="circle-timer" id="circle-timer">
            <div class="timer-content shadow" id="timer-content">
                {{ gmdate("i:s", $remainingSeconds) }} min
            </div>
        </div>
        
    @else
        <!-- Afficher l'image utilisateur -->
        <div class="user-info text-center">
            <img src="{{ asset('userImage.jpg') }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px;">
            <h5>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h5>
        </div>
    @endif

    <ul class="nav flex-column text-center mt-4">
        <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}">Menu du jour</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.order_items.listingOrderMonth') }}">Mes commandes</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('user.monthlyInvoice') }}">Mes factures</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('profile.editUser') }}">Modifier mon profil</a></li>
        <!-- <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Déconnexion</a></li> -->
        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                {{ __('Déconnexion') }}
            </a>
        </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
    </ul>
</div>