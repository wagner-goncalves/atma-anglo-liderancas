<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class PostCriado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $curso, $post)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->curso = $curso;
        $this->post = $post;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(sprintf('Novo post no %s (%s)', $this->curso->nome, $this->empresa->nome))
            ->greeting(sprintf("POSTADO POR: %s - CPF %s", $this->user->name, $this->user->cpf)) 
            ->line(sprintf("CURSO: %s ", $this->curso->nome))
            ->line(sprintf("EMPRESA: %s ", $this->empresa->nome))
            ->line(sprintf("Texto do POST: %s ", $this->post->post))
            ->action('Acessar plataforma',  url('/'));
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
