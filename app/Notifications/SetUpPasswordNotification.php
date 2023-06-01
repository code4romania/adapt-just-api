<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SetUpPasswordNotification extends Notification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $passwordUrl = $this->passwordUrl($notifiable);

        return (new MailMessage)
            ->subject('Cont nou')
            ->greeting('Salut,')
            ->line('Contul tau a fost creat.')
            ->line('Te rugam da click pe link-ul de mai jos pentru a seta o parola.')
            ->action('Seteaza o parola', $passwordUrl);


    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function passwordUrl(mixed $notifiable): string
    {
        /**
         * NOTE:
         *
         * We generate a signed route for the backend and replace the domain with
         * the frontends domain so when the user clicks the mail in the email
         * it will send it to the frontend that will gather the password
         * and make a request to the same API url with the signature
         * and all other params so that we can verify the data
         */
        $backendSignedUrl = URL::temporarySignedRoute(
            'password.setup',
            Carbon::now()->addMinutes(Config::get('auth.password_timeout', 10000)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
            false
        );

        return Str::replace("/api", config('app.web_client_url'), $backendSignedUrl);

    }
}
