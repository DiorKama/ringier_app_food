<x-master-layout>
    <div class="container col-12 mt-5 py-3">
        <!-- Commandes utilisateur du jour -->
        <h4>Commandes utilisateur du jour</h4>
        <div class="row">
            @foreach($userOrders as $userOrder)
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-warning" style="max-width: 18rem;">
                        <!-- Card header with user icon -->
                        <div class="card-header" style="border: none;">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        
                        <!-- User information -->
                        <div class="card-body">
                            <h5 class="card-title text-white">{{ $userOrder['user']->firstName }} {{ $userOrder['user']->lastName }}</h5>
                            <p class="card-text text-white">{{ $userOrder['user']->position }}</p>
                        </div>
                        
                        <!-- Ordered items with delete button -->
                        <div class="card-footer bg-light d-flex flex-column justify-content-between">
                            @foreach($userOrder['items'] as $restaurant => $items)
                                <strong>{{ $restaurant }}</strong>
                                @foreach($items as $item)
                                    <div class="mb-0 d-flex justify-content-between align-items-center"> <!-- Remplacez <p> par <div> -->
                                        <span>{{ $item['item'] }}</span>
                                        <span class="d-flex align-items-center">
                                            <span class="">{{ $item['quantity'] }}x</span>
                                            <form action="" method="POST" class="m-0 p-0"> <!-- Classe ajoutée -->
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light" title="Supprimer">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </span>
                                    </div> <!-- Fermez <div> au lieu de </p> -->
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Commandes restaurant du jour -->
        <h4>Commandes restaurant du jour</h4>
        <div class="row">
            @foreach($restaurantOrders as $restaurantName => $restaurantOrder)
                <div class="col-md-3 mb-4">
                    <div class="card bg-danger text-white" style="max-width: 18rem;">
                        <div class="card-body">
                            <h5>{{ $restaurantName }}</h5>
                            <hr>
                            <!-- List of restaurant orders -->
                            @foreach($restaurantOrder as $order)
                                <p>{{ $order['item'] }}|{{ $order['quantity'] }}x</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-master-layout>





