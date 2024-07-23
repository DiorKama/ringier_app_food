<x-master-layout>
<div class="mt-5 p-4">
    <!-- Display Validation Errors -->
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <h4 class="mb-3">Créer un nouveau Utilisateur</h4>
<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <!-- Autres champs comme firstName, lastName, email, password, etc. -->
    <div class="form-group">
    <label class="form-label" for="form3Example1n">{{ __('Titre') }}</label>
        <select class="form-control" aria-label="Default select example" name="title" :value="old('title', $user->title)">
        <option>Séléctionnez</option>
        @foreach(config('employees.titles') as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
    </div>
    <div class="form-group">
        <label for="firstName">Prenom</label>
        <input type="text" name="firstName" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="lastName">Nom</label>
        <input type="text" name="lastName" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="position">Poste</label>
        <input type="text" name="position" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
    <div class="form-group">
        <label for="phone_number">Telephone</label>
        <input type="text" name="phone_number" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>
</div>

</x-master-layout>