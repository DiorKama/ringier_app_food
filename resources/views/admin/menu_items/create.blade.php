<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Add Menu Item</h4>
        <form action="{{ route('admin.menu_items.store') }}" method="POST">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $defaultMenuId }}">

            <div class="form-group">
                <label for="restaurant_id">Restaurant</label>
                <select name="restaurant_id" class="form-control" id="restaurant_id" required>
                    <option value="">Select a restaurant</option>
                    @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_id">Item</label>
                <select name="item_id" class="form-control" id="item_id" required>
                    <option value="">Select an item</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" class="form-control" id="price" required min="0">
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <select name="active" class="form-control" id="active">
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <script>
        document.getElementById('restaurant_id').addEventListener('change', function () {
            var restaurantId = this.value;
            var itemSelect = document.getElementById('item_id');
            
            // Clear the current options
            itemSelect.innerHTML = '<option value="">Select an item</option>';
            
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




