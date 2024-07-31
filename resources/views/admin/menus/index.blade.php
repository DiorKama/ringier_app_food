<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>List Menus</h4>
        <div class="row mb-3">
            <div class="col-12 text-right">
                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">+ Ajout Menu</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Validated Date</th>
                    <th>Closing Date</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->id }}</td>
                        <td>{{ $menu->title }}</td>
                        <td>{{ $menu->validated_date }}</td>
                        <td>{{ $menu->closing_date }}</td>
                        <td>
                            <span class="badge badge-{{ $menu->active ? 'success' : 'danger' }}">
                                {{ $menu->active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @if($menu->active)
                                <form action="{{ route('admin.menus.deactivate', $menu->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <form action="{{ route('admin.menus.activate', $menu->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>
