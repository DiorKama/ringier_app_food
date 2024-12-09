<x-master-layout>
    <div class="container mt-5 p-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h4>Menu du jour</h4>
        <div class="row">
        @php
            // Récupérer le menu du jour (celui de la date actuelle)
            $menu = \App\Models\Menu::whereDate('created_at', now()->toDateString())->first();
        @endphp
        <div class="col-12 d-flex justify-content-end">
            <!-- Afficher le bouton Publier le menu si le menu n'est pas encore publié -->
            @if(
                !$menu->active
                && is_null($menu->validated_date)
            )
                <form action="{{ route('admin.menu.publish') }}" method="POST" class="mr-2">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <button type="submit" class="btn btn-danger">Publier le menu</button>
                </form>
            @endif

            <!-- Le bouton "Ajouter un plat au menu" est également aligné à droite -->
            <a href="{{ route('admin.menu_items.create') }}" class="btn btn-primary">+ Ajouter un plat au menu</a>
        </div>

            <div class="row mt-3">
                @if($menuItems->isEmpty())
                    <div class="col-12">
                        <p class="text-center">Aucun menu disponible pour aujourd'hui.</p>
                    </div>
                @else
                    @foreach($menuItems as $menuItem)
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                @php
                                    $imagePath = $menuItem->items->item_thumb ? asset($menuItem->items->item_thumb) : asset('default.png');
                                @endphp
                                <a href="{{ route('admin.menu_items.edit', $menuItem->id) }}">
                                    <img class="card-img-top" src="{{ $imagePath }}" alt="{{ $menuItem->items->title }}" style="aspect-ratio: 16 / 9; object-fit: cover;">
                                </a>
                                <div class="card-body text-center">
                                    <h5 class="card-title font-weight-bold float-none">{{ $menuItem->items->title }}</h5>
                                    <p class="card-text">{{ $menuItem->items->restaurants->title }}</p>
                                    <p class="card-text font-weight-bold">{{ number_format($menuItem->price, 0, ',', ' ') }} F CFA</p>
                                    <form action="{{ route('admin.menu_items.destroy', $menuItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-block btn-primary"><i class="fas fa-trash"></i>Retirer</button>
                                    </form>
                                    <div class="mt-3">
                                    <a href="{{ route('admin.order_items.create', ['menu_item_id' => $menuItem->id]) }}" class="btn btn-sm btn-block btn-success">
                                        <i class="fas fa-plus"></i> Commander
                                    </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @include('admin.order_items.index')
    
    <script>
        // Capture la soumission du formulaire
        document.getElementById('orderForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Empêche le rechargement de la page

            // Récupérer les données du formulaire
            let formData = new FormData(this);

            // Faire l'appel AJAX pour envoyer la commande
            fetch("{{ route('admin.order_items.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour la liste des commandes sans rafraîchir la page
                    updateOrdersList();
                }
            })
            .catch(error => console.error('Erreur:', error));
        });

        function updateOrderList() {
            // Effectuer une requête AJAX pour récupérer les commandes mises à jour
            $.ajax({
                url: '/admin/orderItems',
                method: 'GET',
                success: function (data) {
                    // Cibler les conteneurs HTML
                    const userOrderContainer = document.querySelector('.container .row');

                    // Vider les conteneurs avant d'ajouter le nouveau contenu
                    userOrderContainer.innerHTML = '';

                    // Générer les cartes pour les commandes des utilisateurs
                    data.userOrders.forEach(userOrder => {
                        const user = userOrder.user;
                        const items = userOrder.items;

                        let userCard = `
                            <div class="col-md-3 mb-4" id="user-${user.id}">
                                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                                    <div class="card-header bg-warning" style="border: none;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title text-white" style="font-size: 24px;">
                                            ${user.firstName} ${user.lastName}
                                        </h3><br>
                                        <p class="card-text text-white">${user.position}</p>
                                    </div>
                                    <div class="card-footer bg-light" id="user-${user.id}-items">
                        `;

                        // Ajouter les items à la carte
                        Object.keys(items).forEach(restaurant => {
                            const restaurantItems = items[restaurant];
                            Object.keys(restaurantItems).forEach(itemKey => {
                                const item = restaurantItems[itemKey];
                                userCard += `
                                    <p class="mb-0">${item.item} (${restaurant}) | ${item.quantity}x</p>
                                `;
                            });
                        });

                        userCard += `
                                    </div>
                                </div>
                            </div>
                        `;

                        userOrderContainer.innerHTML += userCard;
                    });
                },
                error: function (error) {
                    console.error('Erreur lors de la mise à jour des commandes', error);
                }
            });
        }

    </script>
    

</x-master-layout>

