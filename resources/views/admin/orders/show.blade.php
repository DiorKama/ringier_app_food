<x-master-layout>
<div class="container mt-5 py-5">
    <h4>Détails des commandes pour {{ $user->firstName }} {{ $user->lastName }} - Mois : {{ \Carbon\Carbon::parse($month)->format('F Y') }}</h4>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Numéro de commande</th>
                <th>Plat</th>
                <th>Restaurant</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @foreach($order->orderItems as $orderItem)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $orderItem->menuItems->items->title }}</td>
                        <td>{{ $orderItem->menuItems->items->restaurants->title }}</td>
                        <td>{{ $orderItem->quantity }}</td>
                        <td>{{ $orderItem->unit_price }} </td>
                        <td>{{ $orderItem->unit_price * $orderItem->quantity }} frcs CFA</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

        <div class="mt-4">
            <table class="table table-sm table-bordered" style="width: 50%; max-width: 400px; text-align: center;">
                <thead>
                    <tr>
                        <th>Détails Calcul</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    // Calcul de la réduction avec la subvention
                    $discountedTotal = $totalPrice * (1 - $user->subvention / 100);

                    // Ajout des frais de livraison
                    $finalTotal = $discountedTotal + $user->livraison;
                @endphp
                    <tr>
                        <td class="badge badge-secondary text-wrap" style="width: 14rem;">Total pour le mois</td>
                        <td class="font-weight-bolder">{{ $totalPrice }} frcs CFA</td>
                    </tr>
                    <tr>
                        <td class="badge badge-secondary text-wrap" style="width: 14rem;">Total après subvention ({{ $user->subvention }}%)</td>
                        <td class="font-weight-bolder">{{ number_format($discountedTotal, 0, '.', ' ' ) }} frcs CFA</td>
                    </tr>
                    <tr>
                        <td class="badge badge-secondary text-wrap" style="width: 14rem;">Total avec livraison ({{ $user->livraison }} frcs CFA)</td>
                        <td class="font-weight-bolder">{{ number_format($finalTotal, 0, '.', ' ' ) }} frcs CFA</td>
                    </tr>
                </tbody>
            </table>
        </div>

    <a href="{{ route('admin.reports.monthly') }}" class="btn btn-secondary">Back</a>
</div>

    
</x-master-layout>