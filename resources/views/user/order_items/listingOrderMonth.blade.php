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
        <form action="{{ route('user.order_items.listingOrderMonth') }}" method="GET" class="form-inline mt-4">
            <div class="form-group">
                <label for="month">Mois:</label>
                <select name="month" id="month" class="form-control mx-2">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" 
                                {{ $m == $selectedMonth ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="form-group mx-2">
                <label for="year">Année:</label>
                <select name="year" id="year" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 5; $y--)
                        <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary ml-2">Recherche</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Numéro de Commande</th>
                    <th>Montant Total</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', ' ') }} frcs CFA</td>
                        <td>{{ $order->created_at->format('d F Y') }}</td>
                        <td>
                            <a href="{{ route('user.orders.show', $order->order_id) }}" class="btn btn-sm btn-light">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-users-layout>