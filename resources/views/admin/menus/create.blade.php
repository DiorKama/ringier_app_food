<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Add Menu</h4>
        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="form-group">
                <label for="validated_date">Validated Date</label>
                <input type="date" name="validated_date" class="form-control" id="validated_date">
            </div>
            <div class="form-group">
                <label for="closing_date">Closing Date</label>
                <input type="date" name="closing_date" class="form-control" id="closing_date">
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <select name="active" class="form-control" id="active">
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</x-master-layout>

