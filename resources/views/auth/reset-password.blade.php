<x-monheader></x-monheader>
<div class="reset-background">
    <div class="background-overlay"></div> <!-- Couche de fond pour l’opacité -->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 form-container">
            <!-- Affichage du statut de session -->
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <h2 class="text-center mb-4">{{ __('Réinitialiser le mot de passe') }}</h2>

                <!-- Jeton de réinitialisation du mot de passe -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Adresse e-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Adresse e-mail') }}</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Nouveau mot de passe') }}</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton de soumission -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">{{ __('Réinitialiser le mot de passe') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-monbody></x-monbody>
