<x-monheader>
</x-monheader>

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

<div class="row container mt-5 py-5 ml-3">
    <div class="sidebar col-md-4 bg-light d-flex flex-column align-items-center py-4">
        <div class="user-info text-center">
            <img src="{{ asset('userImage.jpg') }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px;">
            <h3>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h3>
        </div>
        <ul class="nav flex-column text-center mt-4">
            <li class="nav-item"><a class="nav-link" href="">Menu du jour</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.order_items.listingOrderMonth')}}">Mes commandes</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.monthlyInvoice')}}">Mes factures</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Modifier mon profil</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Déconnexion</a></li>
        </ul>
    </div>

    <div class="col-md-1"></div>

    <div class="col md-7 bg-light">
        <h4>Menu du jour</h4>

        @if($menuItems->isEmpty())
            <p>Aucun plat disponible pour ce menu.</p>
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

<div class="col-md-12 bg-light">
    <h5 class="ml-5 mb-3 py-3">Les Commandes du jour</h5>
    <div id="user-orders" class="row ml-3">
        <p>Chargement des commandes...</p>
    </div>
</div>
<section class="footer">
    <div class="container-footer">
        <p>© All Rights Reserved - 2024 - by Expat-Dakar</p>
    </div>
</section>
<x-monbody>
</x-monbody>
    
