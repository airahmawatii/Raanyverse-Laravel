<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification
{
    use Queueable;

    protected $billing;

    public function __construct($billing)
    {
        $this->billing = $billing;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $dueDate = \Carbon\Carbon::parse($this->billing->due_date)->translatedFormat('d F Y');
        $amount  = 'Rp ' . number_format($this->billing->amount, 0, ',', '.');

        return (new MailMessage)
            ->subject('Pengingat Pembayaran - RaanyProp')
            ->greeting('Yth. ' . $notifiable->name . ',')
            ->line('Kami ingin menginformasikan bahwa Anda memiliki tagihan yang akan jatuh tempo dalam 2 (dua) hari.')
            ->line('**Detail Tagihan:**')
            ->line('Periode    : ' . $this->billing->period)
            ->line('Jumlah     : ' . $amount)
            ->line('Jatuh Tempo: ' . $dueDate)
            ->action('Lihat Detail Tagihan', url('/'))
            ->line('Mohon segera melakukan pembayaran sebelum tanggal jatuh tempo untuk menghindari keterlambatan.')
            ->line('Apabila Anda memiliki pertanyaan, silakan menghubungi pengelola properti.')
            ->salutation('Hormat kami, Manajemen RaanyProp');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message'  => 'Pengingat: Tagihan ' . $this->billing->period . ' jatuh tempo dalam 2 hari.',
            'type'     => 'late_payment',
            'sent_at'  => now()->toDateTimeString(),
        ];
    }
}
