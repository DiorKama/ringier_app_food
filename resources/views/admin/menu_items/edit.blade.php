<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Edit Menu Item</h4>
        <form action="{{ route('admin.menu_items.update', $menuItem->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="menu_id" value="{{ $menuItem->menu_id }}">
            <div class="form-group">
                <label for="restaurant_id">Restaurant</label>
                <select name="restaurant_id" class="form-control" id="restaurant_id" required>
                    @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ $menuItem->items->restaurant_id == $restaurant->id ? 'selected' : '' }}>{{ $restaurant->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_id">Item</label>
                <select name="item_id" class="form-control" id="item_id" required>
                    @foreach ($menuItem->items->restaurants->items as $item)
                        <option value="{{ $item->id }}" {{ $menuItem->item_id == $item->id ? 'selected' : '' }}>{{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" id="price" required min="0" value="{{ $menuItem->price }}">
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <select name="active" class="form-control" id="active">
                    <option value="1" {{ $menuItem->active ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ !$menuItem->active ? 'selected' : '' }}>Non</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

    <script>
        document.getElementById('restaurant_id').addEventListener('change', function () {
            var restaurantId = this.value;
            var itemSelect = document.getElementById('item_id');
            
            // Clear the current options
            itemSelect.innerHTML = '<option value="">Selectionnez un plat </option>';
            
            if (restaurantId) {
                fetch(`/api/restaurants/${restaurantId}/items`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            var option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.title;
                            itemSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
</x-master-layout>

