<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>List User</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Poste</th>
                    <th>Subvention</th>
                    <th>Livraison</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->firstName }}</td>
                        <td>{{ $user->lastName }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->position }}</td>
                        <td>{{ $user->subvention }}</td>
                        <td>{{ $user->livraison }}</td>
                        <td>
                            <!-- Admin Management -->
                            @if ($user->role !== 'admin')
                                <form action="{{ route('admin.users.makeAdmin', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Ajout Admin</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.revokeAdmin', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Retirer Admin</button>
                                </form>
                            @endif

                            <!-- Edit and Delete -->
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Modifier</a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Supprimer</button>
                            </form>

                            <!-- Ajuster Subvention Button -->
                            <!-- <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustSubventionModal-{{ $user->id }}">Ajuster Subvention</button> -->
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustSubventionModal-{{ $user->id }}">Ajuster Subvention</button>


                            <!-- Ajuster Livraison Button -->
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustLivraisonModal-{{ $user->id }}">Livraison</button>
                        </td>
                    </tr>

                    <!-- Bouton pour ouvrir le modal -->
                    

                    <!-- Modal pour ajuster la subvention pour chaque utilisateur -->
                    <div class="modal fade" id="adjustSubventionModal-{{ $user->id }}" tabindex="-1" aria-labelledby="adjustSubventionModalLabel-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="adjustSubventionModalLabel-{{ $user->id }}">Ajuster la Subvention</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.users.adjustSubvention', $user->id) }}">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <label for="subvention" class="form-label">Nouveau montant de la subvention</label>
                                        <input type="text" class="form-control" id="subvention" name="subvention" placeholder="20%">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Livraison Modal -->
                    <div class="modal fade" id="adjustLivraisonModal-{{ $user->id }}" tabindex="-1" aria-labelledby="adjustLivraisonModalLabel-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="adjustLivraisonModalLabel-{{ $user->id }}">Ajuster Livraison pour {{ $user->firstName }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.users.adjustLivraison', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="livraison" class="form-label">Livraison</label>
                                            <input type="number" name="livraison" id="livraison" class="form-control" value="{{ $user->livraison }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</x-master-layout>
