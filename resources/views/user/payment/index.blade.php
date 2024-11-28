<x-monheader>
</x-monheader>

<div class="container">
{{--Afficher le message de succès--}}
    @if (isset($success))
        <div class="alert alert-success">
            {{ $success }}
        </div>
    @endif

    {{--Afficher le message d'erreur--}}
    @if (isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif

    <h1>Paiement</h1>
    <p>Bienvenue sur la page de paiement.</p>
    <!-- Contenu supplémentaire -->
</div>
<x-monbody>
</x-monbody>