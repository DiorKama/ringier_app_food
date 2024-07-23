<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>List Restaurant</h4>
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('admin.restaurants.create') }}" class="btn btn-primary mb-3">+ Ajout Restaurant</a>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Telephone</th>
                    <th>Address</th>
                    <th>Active</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->id }}</td>
                        <td>{{ $restaurant->title }}</td>
                        <td>{{ $restaurant->phone_number }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td>
                            <span class="badge badge-{{ $restaurant->active ? 'success' : 'danger' }}">
                                {{ $restaurant->active ? __('Oui') : __('Non') }}
                            </span>
                        </td>
                        <td>{{ $restaurant->created_at->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('admin.restaurants.edit', $restaurant->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                            @if($restaurant->active)
                                <form action="{{ route('admin.restaurants.deactivate', $restaurant->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-ban"></i></button>
                                </form>
                            @else
                                <form action="{{ route('admin.restaurants.activate', $restaurant->id) }}" method="POST" style="display:inline;">
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

