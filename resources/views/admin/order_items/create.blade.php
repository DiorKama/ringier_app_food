<x-master-layout>
<div class="container mt-5 p-4">
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <h4>Ajout Commande du jour</h4>
    <form action="{{ route('admin.order_items.store') }}" id="orderForm" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        
        <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}"> <!-- Ajout de ce champ caché -->

        <div class="form-group">
            <label for="user">Utilisateur</label>
            <select name="user_id" id="user_id" class="form-control" required="required">
                <option value="">Sélectionnez un Utilisateur</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price">Prix</label>
            <input type="number" name="unit_price" class="form-control" id="unit_price" required min="0" value="{{ $menuItem->price }}">   
        </div>

        <div class="form-group">
            <label for="quantity">Quantité</label>
            <input type="number" name="quantity" class="form-control" id="quantity" required min="1" value="1">   
        </div>
        
        <div class="form-group">
            <label for="restaurant_title">Restaurant</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $menuItem->items->restaurants->title }}" readonly> <!-- Correction ici -->
        </div>

        <div class="form-group">
            <label for="item_title">Plat</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $menuItem->items->title }}" readonly> <!-- Correction ici -->
        </div>

        <button type="submit" class="btn btn-primary">Ajouter Commande</button>
    </form>
</div>
</x-master-layout>
