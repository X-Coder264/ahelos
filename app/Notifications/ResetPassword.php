<?php

namespace Ahelos\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('noreply@ahelos.hr', 'Ahelos')
            ->subject('Ponovno postavljanje lozinke')
            ->line('Zaprimili smo zahtjev za izmjenom lozinke. Za promjenu Vaše lozinke kliknite na gumb ispod.')
            ->action('Promjena lozinke', url('password/reset', $this->token))
            ->line('Ako niste zatražili promjenu lozinke molimo da zanemarite ovaj e-mail.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
