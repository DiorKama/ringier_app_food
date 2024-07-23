<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Add Item</h4>
        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="restaurant_id">Restaurant</label>
                <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                    @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_category_id">Category</label>
                <select class="form-control" id="item_category_id" name="item_category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_thumb">Item Thumbnail</label>
                <input type="file" class="form-control" id="item_thumb" name="item_thumb" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</x-master-layout>
