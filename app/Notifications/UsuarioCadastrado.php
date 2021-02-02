<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class UsuarioCadastrado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $roles)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->roles = $roles;
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

        $empresa = is_object($this->empresa) ? $this->empresa->nome : "plataforma";

        $mail = new MailMessage;
        $mail->subject('Administração da plataforma Aldeia Consultoria')
            ->greeting(sprintf("Olá, %s!", $this->user->name)) 
            ->line(sprintf('Você foi cadastrado para gerenciar alunos da %s.', $empresa));
        $papeis = [];
        if(in_array("Admin", $this->roles) ) $papeis[] = "Administrador da plataforma";
        if(in_array("Gestor", $this->roles) ) $papeis[] = "Gestor de alunos da " . $empresa;

        $mail->line("Você recebeu o(s) papel(is) de: " . implode(', ', $papeis))
            ->line('Para acessar a plataforma, clique no link abaixo.')
            ->action('Acessar plataforma',  url('/'))
            ->line('Em seu primeiro acesso, utilize seu E-MAIL e os SEIS PRIMEIROS DÍGITOS do seu CPF para acessar a plataforma.');

        return $mail;
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
