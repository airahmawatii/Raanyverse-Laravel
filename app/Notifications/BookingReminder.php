<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingReminder extends Notification
{
    use Queueable;

    protected $message;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $type = 'info')
    {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // AnonymousNotifiable (Notification::route) tidak support database channel
        if ($notifiable instanceof \Illuminate\Notifications\AnonymousNotifiable) {
            return ['mail'];
        }
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public f  rrrrrunction toMail(object $notifiable): MailMessage
    {
        $judul = ucwords(str_replace('_', ' ', $this->type));
        $nama = optional($notifiable)->name ?? 'Pengguna';
        
        return (new MailMessage)
            ->subject('Notifikasi RaanyProp: ' . $judul)
            ->greeting('Halo ' . $nama . ',')
            ->line('Kamu memiliki notifikasi baru.')
            ->line($this->message)
            ->action('Buka RaanyProp', url('/'))
            ->line('Terima kasih telah menggunakan layanan kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'type' => $this->type,
            'sent_at' => now()->toDateTimeString(),
        ];
    }
}
