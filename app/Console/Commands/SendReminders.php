<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automated move-in and payment reminders to tenants.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting reminder check...');

        // 1. Move-in Reminders (3 days before start)
        $upcoming = \App\Models\Booking::where('status', 'approved')
            ->where('start_date', now()->addDays(3)->toDateString())
            ->get();

        foreach ($upcoming as $booking) {
            $booking->tenant->notify(new \App\Notifications\BookingReminder(
                "Reminder: Your stay at {$booking->unit->name} starts in 3 days!",
                'upcoming_booking'
            ));
            $this->info("Notified booking #{$booking->id}");
        }

        // 2. Unpaid Billing Reminders (every 5 days since creation)
        $unpaid = \App\Models\Billing::where('status', 'unpaid')
            ->where('created_at', '<=', now()->subDays(5))
            ->get();

        foreach ($unpaid as $bill) {
            $bill->tenant->notify(new \App\Notifications\BookingReminder(
                "Notice: You have an unpaid invoice for {$bill->period} amounting Rp " . number_format($bill->amount),
                'late_payment'
            ));
            $this->info("Notified billing #{$bill->id}");
        }

        $this->info('Reminder check complete.');
    }
}
