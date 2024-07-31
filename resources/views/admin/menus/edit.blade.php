<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Edit Menu</h4>
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $menu->title }}" required>
            </div>
            <div class="form-group">
                <label for="validated_date">Validated Date</label>
                <input type="date" name="validated_date" class="form-control" id="validated_date" value="{{ $menu->validated_date }}">
            </div>
            <div class="form-group">
                <label for="closing_date">Closing Date</label>
                <input type="date" name="closing_date" class="form-control" id="closing_date" value="{{ $menu->closing_date }}">
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <select name="active" class="form-control" id="active">
                    <option value="1" {{ $menu->active ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ !$menu->active ? 'selected' : '' }}>Non</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-master-layout>

