<x-users-layout>

<div class="row container mt-5 py-5 ml-3">
    <div class="sidebar col-md-4 bg-light d-flex flex-column align-items-center py-4">
        <div class="user-info text-center">
            <img src="{{ asset('userImage.jpg') }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px;">
            <h3>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h3>
        </div>
        <ul class="nav flex-column text-center mt-4">
            <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard')}}">Menu du jour</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.order_items.listingOrderMonth')}}">Mes commandes</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.monthlyInvoice')}}">Mes factures</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('profile.editUser')}}">Modifier mon profil</a></li>
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

        <div class="invoice-container">
               <h4 class="invoice-header">Facture</h4>

                <form method="GET" action="{{ route('user.monthlyInvoice') }}" class="mt-3">
                    <label for="month">Mois :</label>
                    <input type="month" id="month" name="month" value="{{ $selectedMonth instanceof \Carbon\Carbon ? $selectedMonth->format('Y-m') : $selectedMonth }}">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                    <a href="{{ route('user.monthlyInvoice') }}" class="btn btn-secondary ml-5">Réinitialiser</a>
                </form>

                @foreach ($userData as $restaurant)
                    <div class="invoice-section">
                        <div class="restaurant-name">{{ $restaurant['restaurant_name'] }}</div>
                        <div class="item-list">
                            @foreach ($restaurant['items'] as $item)
                                <p>
                                    <span class="item-title">{{ $item['title'] }}</span>
                                    <span>{{ $item['total_quantity'] }} × {{ number_format($item['unit_price'], 0, '.', ' ') }} F CFA</span>
                                    <span>{{ number_format($item['total_price'], 0, '.', ' ') }} F CFA</span>
                                </p>
                            @endforeach
                        </div>
                        <div class="summary-row">
                            <span>Total pour {{ $restaurant['restaurant_name'] }}:</span>
                            <span>{{ number_format($restaurant['total_amount'], 0, '.', ' ') }} F CFA</span>
                        </div>
                    </div>
                @endforeach

            <div class="total-section">
                    <div class="summary-row">
                        <span>Total brut :</span>
                        <span>{{ number_format($totalBrut, 0, '.', ' ') }} F CFA</span>
                    </div>
                    <div class="summary-row">
                        <span>Subvention :</span>
                        <span>{{ $subvention }}%</span>
                    </div>
                    <div class="summary-row">
                        <span>Livraison :</span>
                        <span>{{ number_format($deliveryFee, 0, '.', ' ') }} F CFA</span>
                    </div>
                    <div class="summary-row total-amount">
                        <span>Total :</span>
                        <span>{{ number_format($finalTotal, 0, '.', ' ') }} F CFA</span>
                    </div>
                <!-- Formulaire de paiement -->
                    <form method="POST" action="{{ route('user.pay') }}">
                        @csrf
                        <input type="hidden" name="payment_period" value="{{ $selectedMonth->format('Y-m') }}">
                        <input type="hidden" name="amount" value="{{ $finalTotal }}">
                        <div class="summary-row">
                            @php
                                $paymentMethods = config('payments.methods', []);
                            @endphp

                            @if (!empty($paymentMethods))
                                @foreach ($paymentMethods as $method)
                                    <button
                                        type="submit"
                                        class="btn btn-{{ str_replace('-', '_', $method) }}"
                                        name="method"
                                        value="{{ $method }}"
                                    >
                                        <img 
                                            src="{{ asset('' . $method . '.png') }}" 
                                            alt="{{ ucfirst(str_replace('-', ' ', $method)) }}" 
                                            class="payment-icon"
                                        >
                                        {{ ucfirst(str_replace('-', ' ', $method)) }}
                                    </button>
                                @endforeach

                            @else
                                <p>Aucun moyen de paiement disponible</p>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-users-layout>
    