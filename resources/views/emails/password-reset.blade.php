@component('mail::message')
# Réinitialisation de votre mot de passe

Bonjour {{ $notifiable->firstName }},

Vous recevez cet email car nous avons reçu une demande de réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour réinitialiser votre mot de passe.

@component('mail::button', ['url' => $url])
Réinitialiser le mot de passe
@endcomponent

Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.

Cordialement,  
{{ config('app.name') }}

---

Si vous avez des difficultés à cliquer sur le bouton "Réinitialiser le mot de passe", copiez et collez l'URL suivante dans votre navigateur :  
[{{ $url }}]({{ $url }})
@endcomponent
