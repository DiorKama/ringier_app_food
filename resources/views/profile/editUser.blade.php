<x-users-layout>

<div class="row container mt-5 py-5 ml-3">
    <div class="sidebar col-md-4 bg-light d-flex flex-column align-items-center py-4">
        <div class="user-info text-center">
            <img src="{{ asset('userImage.jpg') }}" alt="User Image" class="rounded-circle" style="width: 150px; height: 150px;">
            <h3>{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h3>
        </div>
        <ul class="nav flex-column text-center mt-4">
            <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard')}}">Menu du jour</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.order_items.listingOrderMonth')}}">Mes commandes</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('user.monthlyInvoice')}}">Mes factures</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit')}}">Modifier mon profil</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Déconnexion') }}
                </a>
            </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
        </ul>
    </div>

    <div class="col-md-1"></div>

   <div class="col md-7 bg-light">
    <div class="container mt-5">
        <!-- Formulaire pour envoyer la vérification de l'email -->
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <!-- Formulaire de mise à jour du profil -->
        <form method="post" action="{{ route('profile.updateUser') }}" class="mt-4">
            @csrf
            @method('patch')

            <!-- Champ Civilité -->
            <div class="form-group">
                <label for="title">Civilité</label>
                <select class="form-control" id="title" name="title">
                    @foreach(config('employees.titles') as $key => $label)
                        <option value="{{ $key }}" {{ old('title', $user->title) === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Champ Prénom -->
            <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName', $user->firstName) }}" required autocomplete="firstName">
                @if($errors->has('firstName'))
                    <small class="text-danger">{{ $errors->first('firstName') }}</small>
                @endif
            </div>

            <!-- Champ Nom -->
            <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName', $user->lastName) }}" required autocomplete="lastName">
                @if($errors->has('lastName'))
                    <small class="text-danger">{{ $errors->first('lastName') }}</small>
                @endif
            </div>

            <!-- Champ Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @if($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif

                <!-- Message de vérification d'email -->
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-muted">
                            Votre adresse email n'est pas vérifiée.
                            <button form="send-verification" class="btn btn-link p-0 text-primary">
                                Cliquez ici pour renvoyer l'email de vérification.
                            </button>
                        </p>
                        
                        @if (session('status') === 'verification-link-sent')
                            <p class="text-success">
                                Un nouveau lien de vérification a été envoyé à votre adresse email.
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Bouton de sauvegarde et message de confirmation -->
            <div class="form-group d-flex align-items-center gap-4">
                <button type="submit" class="btn btn-primary">Enregistrer</button>

                @if (session('status') === 'profile-updated')
                    <p class="text-success ml-3 mb-0">Enregistré.</p>
                @endif
            </div>
        </form>
    </div>
        
    </div>
</div>


</x-users-layout>
