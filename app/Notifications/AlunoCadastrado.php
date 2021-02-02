<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class AlunoCadastrado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $empresa, $curso)
    {
        $this->user = $user;
        $this->empresa = $empresa;
        $this->curso = $curso;
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
        if($this->curso->id == "1"){
            $mailMessage = new MailMessage();
            $mailMessage->subject('Cadastrado na plataforma Aldeia Consultoria')
            ->greeting('Olá! Recebemos a efetivação da sua inscrição e estamos felizes em estar ao seu lado neste momento tão importante: a experiência da maternidade e da paternidade.') 
            ->line('Este é um convite para que você se sinta acolhido(a), seguro(a) e utilize essa oportunidade como aprendizado. Aproveite ao máximo cada conteúdo, no seu tempo, respeitando seus limites e suas escolhas.')
            ->line('INFORMAÇÕES SOBRE O PROGRAMA:')
            ->line('Nosso curso está dividido em 3 módulos, cada um com temas específicos para cada momento vivenciado durante a gestação e chegada do bebê.')
            ->line('Inclui material de apoio, atividades práticas e reflexivas, aula bônus, espaço para dúvidas e troca de experiências e certificado de conclusão.')
            ->line('Será um grande prazer ter você conosco! ')
            ->markdown('vendor.notifications.email-aluno', ['nome' => "Karina Lara"]);;
            return $mailMessage;
        }

        return (new MailMessage)
            ->subject('Cadastrado na plataforma Aldeia Consultoria')
            ->greeting(sprintf("Olá, %s!", $this->user->name)) 
            ->line(sprintf('Você foi cadastrado no curso %s pela %s.', $this->curso->nome, $this->empresa->nome))
            ->line('Para acessar a plataforma, clique no link abaixo.')
            ->action('Acessar curso',  url('/'))
            ->line('Em seu primeiro acesso, utilize seu E-MAIL e os SEIS PRIMEIROS DÍGITOS do seu CPF para acessar a plataforma.')
            ->line('contato@aldeiaconsultoria.com.br | (31) 99106-6565');
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
