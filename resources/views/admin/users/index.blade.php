<x-master-layout>
    <div class="container mt-5 p-4">
        <h4> List User</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Poste</th>
                    <!-- <th>Role</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->firstName }}</td>
                        <td>{{ $user->lastName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->position }}</td>
                        <!-- <td>{{ $user->role }}</td> -->
                        <td>
                            @if ($user->role !== 'admin')
                                <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" style="white-space: nowrap;">Ajout Admin</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.revokeAdmin', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" style="white-space: nowrap;">Retirer Admin</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm" style="white-space: nowrap;">
                                <i class="fas fa-pencil-alt"></i> Modifier
                            </a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="white-space: nowrap;" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>