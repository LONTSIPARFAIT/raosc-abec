<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationStatusChanged extends Notification
{
    use Queueable;

    protected $organization;
    protected $status;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($organization, $status, $reason = null)
    {
        $this->organization = $organization;
        $this->status = $status;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Mise à jour de votre structure RAOSC')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($this->getMessage());

        if ($this->status === 'approved') {
            $message->action('Voir mon profil public', url('/rao/orga/' . $this->organization->slug));
        }

        if ($this->status === 'rejected' && $this->reason) {
            $message->line('Motif du rejet : ' . $this->reason);
            $message->line('Vous pouvez corriger vos informations et soumettre à nouveau votre demande.');
        }

        $message->line("Merci de faire partie du réseau RAOSC.")
                ->salutation("L'Équipe ABEC");

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'organization_id' => $this->organization->id,
            'organization_name' => $this->organization->name,
            'status' => $this->status,
            'reason' => $this->reason,
            'message' => $this->getMessage(),
        ];
    }

    protected function getMessage()
    {
        return match ($this->status) {
            'approved' => "Votre organisation '{$this->organization->name}' a été approuvée par l'ABEC.",
            'rejected' => "Votre demande pour '{$this->organization->name}' a été rejetée.",
            'suspended' => "Votre organisation '{$this->organization->name}' a été suspendue.",
            default => "Mise à jour du statut de votre organisation.",
        };
    }
}
