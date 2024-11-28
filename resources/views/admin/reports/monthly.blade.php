<x-master-layout>
    <div class="container mt-5 py-5">
        <h2>Rapport des commandes mensuelles</h2>

    <form action="{{ route('admin.reports.monthly') }}" method="GET" class="mt-3">
    <div class="row d-flex align-items-end">
        <div class=" form-group col-md-4">
            <label for="user_id">Utilisateur</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">Sélectionnez un utilisateur</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $userId ? 'selected' : '' }}>
                        {{ $user->title }} {{ $user->firstName }} {{ $user->lastName }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-md-4">
            <label for="month">Mois</label>
            <input type="month" name="month" id="month" class="form-control" value="{{ $month }}">
        </div>
        <div class="form-group col-md-2">
              <button type="submit" class="btn btn-primary">Recherche</button>
        </div>
        <div class="form-group col-md-2">
               <a href="{{ route('admin.reports.monthly') }}" class="btn btn-secondary">Réinitialiser</a>
        </div>
    </div>
</form>

<!-- Table de résultats -->
<table class="table">
    <thead>
        <tr>
            <th>Civilité</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Poste occupé</th>
            <th>Total brut</th>
            <th>Taux subvention</th>
            <th>Livraison</th>
            <th>Total</th>
            <th>Total - livraison incluse</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->user->title }}</td>
                <td>{{ $order->user->firstName }}</td>
                <td>{{ $order->user->lastName }}</td>
                <td>{{ $order->user->position }}</td>
                <td>{{ $order->total_price }} frcs CFA</td>
                <td>{{ $order->user->subvention }}%</td>
                <td>{{ $order->user->livraison }} frcs CFA</td>
                <td>{{ $order->total_price * (1 - $order->user->subvention / 100) }} frcs CFA</td>
                <td>{{ $order->total_price * (1 - $order->user->subvention / 100) + $order->user->livraison }} frcs CFA</td>
                <td>
                <a href="{{ route('admin.orders.show', ['user_id' => $order->user->id, 'month' => $month]) }}" class="btn btn-info">Détails</a>
                <form action="{{ route('admin.orders.pay') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $order->user->id }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="total_to_pay" value="{{ $order->total_price * (1 - $order->user->subvention / 100) + $order->user->livraison }}">
                    <button type="submit" class="btn btn-danger">
                        Payer {{ number_format($order->total_price * (1 - $order->user->subvention / 100) + $order->user->livraison, 2) }} frcs CFA
                    </button>
                </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
</x-master-layout>



  