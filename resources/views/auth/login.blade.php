<x-monheader>
</x-monheader>

<div class="login-background">
    <div class="background-overlay"></div> <!-- Couche de fond pour l’opacité -->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 form-container">
            <!-- Affichage du statut de session -->
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="text-center mb-4">{{ __('Expat Dakar Food') }}</h3>

                <!-- Adresse email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="form-check mb-3">
                    <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label">{{ __('Se souvenir de moi') }}</label>
                </div>

                <!-- Boutons et liens -->
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">{{ __('Mot de passe oublié') }}</a>
                    @endif
                    <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-monbody>
</x-monbody>
