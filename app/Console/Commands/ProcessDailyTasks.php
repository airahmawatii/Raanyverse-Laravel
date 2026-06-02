<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Billing;
use App\Models\Rental;
use Carbon\Carbon;

class ProcessDailyTasks extends Command
{
    protected $signature = 'app:process-daily-tasks';
    protected $description = 'Process daily tasks: overdue billing fines and expired rental releases.';

    public function handle()
    {
        $this->info('Processing daily tasks...');

        // 1. Overdue Check & Fine Accumulation
        $lateBillings = Billing::whereIn('status', ['unpaid', 'overdue'])
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString())
            ->get();

        $overdueCount = 0;
        foreach ($lateBillings as $billing) {
            $dueDate = Carbon::parse($billing->due_date);
            $graceEnd = $dueDate->copy()->addDays(3);

            // Only apply fine after grace period (3 days after due_date)
            if (now()->lt($graceEnd)) {
                // Still within grace period — mark overdue but no fine yet
                $billing->update([
                    'status' => 'overdue',
                    'fine_amount' => 0,
                ]);
            } else {
                // Days late counted from due_date (not grace period end)
                $daysLate = now()->diffInDays($dueDate);

                // 1% per day of billing amount, capped at 30%
                $finePercent = min($daysLate * 1, 30);
                $fineAmount = round($billing->amount * $finePercent / 100);

                $billing->update([
                    'status' => 'overdue',
                    'fine_amount' => $fineAmount,
                ]);
            }
            $overdueCount++;
        }
        $this->info("Marked {$overdueCount} billing(s) as overdue.");

        // 2. Automatic Rental Expiry (Auto-Release Units)
        $expiredRentals = Rental::where('end_date', '<', now()->toDateString())->get();
        $expiredCount = 0;
        foreach ($expiredRentals as $rental) {
            if ($rental->unit) {
                $rental->unit->update(['status' => 'available']);
            }
            $rental->delete();
            $expiredCount++;
        }
        $this->info("Released {$expiredCount} expired rental(s).");

        $this->info('Daily tasks complete.');
    }
}
