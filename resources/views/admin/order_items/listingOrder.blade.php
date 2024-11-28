<x-master-layout>
    <div class="container mt-5 py-4">
        <h4>Toutes les commandes</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>N° Commande</th>
                    <th>Montant total</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->total_price }} CFA</td>
                <td>
                    @if ($order->orders && $order->orders->user)
                        {{ $order->orders->user->firstName }} {{ $order->orders->user->lastName }}
                    @else
                        Utilisateur inconnu
                    @endif
                </td>
                <td>{{ $order->created_at->toDateString() }}</td>
                <td>
                    <a href="{{ route('admin.order_items.show', $order->id) }}">Détails</a>
                    <a href="{{ route('admin.order_items.edit', $order->id) }}">Modifier</a>
                    <form action="{{ route('admin.order_items.destroy', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>
