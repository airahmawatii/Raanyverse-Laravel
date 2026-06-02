<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class CleanupKtpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-ktp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically delete KTP pictures from Cloudinary for bookings approved for over 14 days for PDP compliance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting KTP retention cleanup...');
        Log::info('Artisan Command: starting KTP retention cleanup...');

        $bookings = Booking::where('status', 'approved')
            ->where('updated_at', '<', now()->subDays(14))
            ->whereNotNull('ktp_url')
            ->get();

        $count = 0;

        foreach ($bookings as $booking) {
            $publicId = $this->getCloudinaryPublicId($booking->ktp_url);
            if ($publicId) {
                try {
                    $this->info("Deleting KTP from Cloudinary with Public ID: {$publicId}");
                    cloudinary()->uploadApi()->destroy($publicId);
                } catch (\Exception $e) {
                    $this->error("Failed to delete from Cloudinary: " . $e->getMessage());
                    Log::error("Failed to delete KTP from Cloudinary for booking ID {$booking->id}: " . $e->getMessage());
                }
            }

            $booking->update(['ktp_url' => null]);
            $count++;
        }

        $this->info("Successfully cleaned up {$count} KTP records.");
        Log::info("Successfully cleaned up {$count} KTP records.");
    }

    /**
     * Extract Cloudinary Public ID from URL.
     */
    private function getCloudinaryPublicId($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) return null;

        // Remove file extension
        $pathWithoutExt = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);

        // Find after '/upload/'
        $parts = explode('/upload/', $pathWithoutExt);
        if (count($parts) < 2) return null;

        // The path after '/upload/' starts with v[digits]/[public_id]
        $subPath = $parts[1];
        $subParts = explode('/', $subPath, 2);

        if (count($subParts) == 2 && preg_match('/^v\d+$/', $subParts[0])) {
            return $subParts[1];
        }

        return $subPath;
    }
}
