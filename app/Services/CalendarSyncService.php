<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CalendarSyncService
{
    /**
     * Mock syncing a booking to Google Calendar.
     * In a real app, this would use Google API Socialite/OAuth.
     */
    public function syncBooking(Booking $booking)
    {
        Log::info("SYNC: Syncing Booking #{$booking->id} for Unit {$booking->unit->name} to Google Calendar.");

        // Simulate API latency
        usleep(500000); 

        $mockEventId = 'mock_event_' . Str::random(10);

        $booking->update([
            'google_calendar_event_id' => $mockEventId,
            'is_synced' => true
        ]);

        return [
            'success' => true,
            'event_id' => $mockEventId,
            'message' => 'Successfully synced to Google Calendar (Simulated)'
        ];
    }

    /**
     * Mock disconnecting/deleting from calendar.
     */
    public function disconnect(Booking $booking)
    {
        Log::info("SYNC: Disconnecting Booking #{$booking->id} from Google Calendar.");

        $booking->update([
            'google_calendar_event_id' => null,
            'is_synced' => false
        ]);

        return true;
    }
}
