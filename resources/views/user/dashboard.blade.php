<x-users-layout> 
<div class="row container mt-5 py-5 ml-3">
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

        <div class="col-md-1"></div>

        <div class="col md-7 bg-light">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <h4>Menu du jour</h4>

            @if($menuItems->isEmpty())
                <p class="text-primary">Aucun menu disponible pour le moment.</p>
            @else
                <div class="row">
                    @foreach($menuItems as $menuItem)
                        <div class="col-md-4">
                            <div class="card-header">
                                @php
                                    $imagePath = $menuItem->items->item_thumb ? asset($menuItem->items->item_thumb) : asset('default.png');
                                @endphp
                                <img class="card-img-top" src="{{ $imagePath }}" alt="{{ $menuItem->items->title }}" style="aspect-ratio: 16 / 9; object-fit: cover;">
                                <div class="card-body">
                                    <p class="card-text text-center mb-0">{{ $menuItem->items->restaurants->title }}</p>
                                    <h6 class="card-title text-center mb-2">{{ $menuItem->items->title }}</h6>
                                <hr class="">
                                    <p class="card-text text-center">{{ $menuItem->price }} CFA</p>
                                    <a href="#" class="btn btn-danger btn-sm btn-block add-to-cart" data-id="{{ $menuItem->id }}"><i class="fas fa-plus"></i> Ajouter</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Contenu du modal directement dans le fichier index -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Votre Panier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(auth()->user()->getDailyOrder() && auth()->user()->getDailyOrder()->items->count() > 0)
                        <ul class="list-group">
                            @foreach(auth()->user()->getDailyOrder()->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->menuItems->items->restaurants->title }} - {{ $item->menuItems->items->title }} - {{ $item->quantity }} x {{ $item->unit_price }} CFA
                                    <form action="{{ route('user.order.removeItem', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Votre panier est vide.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="col-md-12 bg-light commandeDay">
        <h5 class="ml-5 mb-3 py-3">Les Commandes du jour</h5>
        <div id="user-orders" class="row ml-5">
            <p>Chargement des commandes...</p>
        </div>

    </div>
    

        <script>
            @if($menu && $menu->validated_date)
                var publicationTimestamp = @json(strtotime($menu->validated_date) * 1000);
                var countdownDuration = 30 * 60 * 1000; // Durée de 30 minutes en millisecondes
                var currentTime = new Date().getTime();

                var remainingSeconds = Math.floor((publicationTimestamp + countdownDuration - currentTime) / 1000);
            @else
                // Aucun menu publié; définir remainingSeconds à 0
                var remainingSeconds = 0;
            @endif

            var circleTimer = document.getElementById('circle-timer');
            var timerContent = document.getElementById('timer-content');
            var userInfoContent = `
                <div class="user-info text-center">
                    <img src="{{ asset('userImage.jpg') }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px;">
                    <h3>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h3>
                </div>
            `;

            function startChronometer(duration) {
                var timer = duration;
                var interval = setInterval(function () {
                    if (timer <= 0) {
                        clearInterval(interval);

                        // Masquer le cercle du chronomètre
                        circleTimer.style.display = 'none';

                        // Afficher les informations de l'utilisateur
                        timerContent.innerHTML = userInfoContent;
                        return;
                    }

                    var minutes = Math.floor(timer / 60);
                    var seconds = timer % 60;
                    timerContent.textContent = `${minutes} min`;
                    var angle = (seconds / 60) * 360;
                    circleTimer.style.setProperty('--angle', `${angle}deg`);

                    timer--;
                }, 1000);
            }

            window.onload = function () {
                if (remainingSeconds > 0) {
                    startChronometer(remainingSeconds);
                } else {
                    circleTimer.style.display = 'none';
                    timerContent.innerHTML = userInfoContent;
                }
            };
        </script>
</x-users-layout>




