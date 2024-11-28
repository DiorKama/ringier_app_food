<x-master-layout>
    <div class="container mt-5 py-5">
        <h3>Rapport Mensuel des Commandes</h3>
        <form method="GET" action="{{ route('admin.reportRestaurants.monthly') }}" class="mb-4">
            <label for="month">Mois :</label>
            <input type="month" id="month" name="month" value="{{ $selectedMonth->format('Y-m') }}">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            <a href="{{ route('admin.reportRestaurants.monthly') }}" class="btn btn-secondary ml-5">Réinitialiser</a>
        </form>

        @foreach($restaurantData as $restaurant)
            <div class="restaurant-report">
                <h4>{{ $restaurant['restaurant_name'] }} - Total: {{ number_format($restaurant['total_amount'], 0, ',', ' ') }} CFA</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité Totale</th>
                            <th>Montant Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($restaurant['items'] as $item)
                            <tr>
                                <td>{{ $item['title'] }}</td>
                                <td>{{ number_format($item['unit_price'], 0, ',', ' ') }} CFA</td>
                                <td>{{ $item['total_quantity'] }}</td>
                                <td>{{ number_format($item['total_price'], 0, ',', ' ') }} CFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-master-layout>
