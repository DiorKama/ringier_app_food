<x-monheader></x-monheader>

<div class="background-image d-flex justify-content-center align-items-center min-vh-100">
<div class="background-overlay"></div>
    <div class="col-md-6">
        <div class="card shadow-sm p-4 ml-5">
            <div class="card-body">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __("Vous avez oublié votre mot de passe ? Pas de problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.") }}
                </div>

                <!-- Statut de session -->
                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Adresse email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bouton d'envoi -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Envoyer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-monbody></x-monbody>

