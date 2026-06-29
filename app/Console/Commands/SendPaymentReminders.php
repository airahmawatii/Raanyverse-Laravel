<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Notifications\PaymentReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:send-payment-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Mengirimkan notifikasi pengingat pembayaran kepada tenant yang tagihannya jatuh tempo dalam 2 hari.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $targetDate = Carbon::today()->addDays(2)->toDateString();

        $billings = Billing::with('tenant')
            ->where('status', 'unpaid')
            ->whereDate('due_date', $targetDate)
            ->get();

        if ($billings->isEmpty()) {
            $this->info('Tidak ada tagihan yang jatuh tempo dalam 2 hari.');
            return;
        }

        foreach ($billings as $billing) {
            if ($billing->tenant) {
                $billing->tenant->notify(new PaymentReminder($billing));
                $this->info('Pengingat berhasil dikirim ke: ' . $billing->tenant->email . ' (' . $billing->period . ')');
            }
        }

        $this->info('Selesai. Total pengingat terkirim: ' . $billings->count());
    }
}
