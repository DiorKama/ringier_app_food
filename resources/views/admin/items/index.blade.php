<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>List Items</h4>
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('admin.items.create') }}" class="btn btn-primary mb-3">+ Ajout Plat</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Thumbnail</th>
                    <th>Restaurant</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            @if($item->item_thumb)
                                <img src="{{ asset($item->item_thumb) }}" alt="Item Thumbnail" width="50">
                            @endif
                        </td>
                        <td>{{ $item->restaurants->title }}</td>
                        <td>{{ $item->categories->title }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                            <span class="badge badge-{{ $item->active ? 'success' : 'danger' }}">
                                {{ $item->active ? __('Oui') : __('Non') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @if ($item->active)
                                <form action="{{ route('admin.items.deactivate', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.items.activate', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>
