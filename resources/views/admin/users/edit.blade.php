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
        <h4 class="mb-3">Modifier l'utilisateur</h4>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
            <label class="form-label" for="form3Example1n">{{ __('Titre') }}</label>
                <select class="form-control" aria-label="Default select example" name="title">
                <option value="">Sélectionnez</option>
                    @foreach(config('employees.titles') as $k => $v)
                        @if($k == $user->title)
                        <option value="{{ $k }}" selected>{{ $v }}</option>
                        @else
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="firstName">Prenom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName', $user->firstName) }}" required>
            </div>
            <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName', $user->lastName) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Telephone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
            </div>
            <div class="form-group">
                <label for="position">Poste</label>
                <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $user->position) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</x-master-layout>
