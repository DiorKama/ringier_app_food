<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    /**
     * Créez une nouvelle notification de réinitialisation de mot de passe personnalisée.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }

    /**
     * Construisez l'email de réinitialisation de mot de passe.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset()
        ]));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour ' . $notifiable->firstName . ',') // Utilisez les attributs de l'utilisateur, comme firstName
            ->line("Vous recevez cet email car nous avons reçu une demande de réinitialisation de votre mot de passe.")
            ->action('Réinitialiser le mot de passe', $url)
            ->line("Si vous n'avez pas demandé de réinitialisation, aucune action n'est nécessaire.")
            ->salutation('Cordialement,')
            ->markdown('emails.password-reset', [
                'url' => $url,
                'notifiable' => $notifiable // Ajoutez cette ligne
            ]);
            
    }
}

