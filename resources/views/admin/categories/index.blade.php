<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Listes des Categories</h4>
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">+ Ajout Category</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Active</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <span class="badge badge-{{ $category->active ? 'success' : 'danger' }}">
                                {{ $category->active ? __('Oui') : __('Non') }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                                @if($category->active)
                                    <form action="{{ route('admin.categories.deactivate', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-ban"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.categories.activate', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Activer</button>
                                    </form>
                                @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>
