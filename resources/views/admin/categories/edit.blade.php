<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Modifier la categorie</h4>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $category->title }}" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent Category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">No Parent</option>
                    @foreach ($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $category->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <input type="checkbox" name="active" id="active" value="1" {{ $category->active ? 'checked' : '' }}>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</x-master-layout>
