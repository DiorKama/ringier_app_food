<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Edit Item</h4>
        <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $item->title }}" required>
            </div>
            <div class="form-group">
                <label for="restaurant_id">Restaurant</label>
                <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                    @foreach ($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" {{ $restaurant->id == $item->restaurant_id ? 'selected' : '' }}>
                            {{ $restaurant->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_category_id">Category</label>
                <select class="form-control" id="item_category_id" name="item_category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $item->item_category_id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="item_thumb">Item Thumbnail</label>
                <input type="file" class="form-control" id="item_thumb" name="item_thumb">
                @if($item->item_thumb)
                    <img src="{{ asset($item->item_thumb) }}" alt="Item Thumbnail" width="50" class="mt-2">
                @endif
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $item->price }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier Plat</button>
        </form>
    </div>
</x-master-layout>
