<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use App\Models\GoogleCalendarEvent;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CalendarSyncService
{
    /**
     * Get Google API Client instance for a given user.
     * Refreshes the access token automatically if expired.
     */
    public function getGoogleClientForUser(User $user)
    {
        if (!$user->google_refresh_token) {
            Log::warning("User #{$user->id} is not connected to Google OAuth (no refresh token).");
            return null;
        }

        $client = new \Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        
        $client->setAccessToken([
            'access_token' => $user->google_access_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => $user->google_token_expires_at ? max(0, $user->google_token_expires_at->getTimestamp() - time()) : 0,
        ]);

        if ($client->isAccessTokenExpired()) {
            try {
                $tokenResponse = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                if (isset($tokenResponse['access_token'])) {
                    $user->update([
                        'google_access_token' => $tokenResponse['access_token'],
                        'google_token_expires_at' => now()->addSeconds($tokenResponse['expires_in'] ?? 3600),
                    ]);
                } else {
                    Log::error("Failed to refresh Google token for User #{$user->id}: Token response missing access_token");
                    return null;
                }
            } catch (\Exception $e) {
                Log::error("Exception refreshing Google Token for User #{$user->id}: " . $e->getMessage());
                return null;
            }
        }

        return $client;
    }

    /**
     * Syncs a booking to Google Calendar.
     */
    public function syncBooking(Booking $booking)
    {
        $user = $booking->tenant;
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Booking has no associated tenant.'
            ];
        }

        $client = $this->getGoogleClientForUser($user);
        if (!$client) {
            return [
                'success' => false,
                'message' => 'User Google account is not connected or authorization expired.'
            ];
        }

        try {
            $service = new \Google\Service\Calendar($client);
            
            $unitName = $booking->unit->name ?? 'Unit #' . $booking->unit_id;
            $summary = "Sewa Unit: {$unitName} (PropVerse)";
            $description = "Booking ID: #{$booking->id}\nStatus: {$booking->status}\nTipe Pembayaran: " . ucfirst($booking->payment_type) . "\nDurasi: {$booking->duration_months} Bulan";

            // All-day event start and end dates (Google end date is exclusive, so add 1 day)
            $startDate = Carbon::parse($booking->start_date)->toDateString();
            $endDate = Carbon::parse($booking->end_date)->addDay()->toDateString();

            $eventData = [
                'summary' => $summary,
                'description' => $description,
                'start' => [
                    'date' => $startDate,
                    'timeZone' => 'Asia/Jakarta',
                ],
                'end' => [
                    'date' => $endDate,
                    'timeZone' => 'Asia/Jakarta',
                ],
            ];

            $event = new \Google\Service\Calendar\Event($eventData);

            if ($booking->google_calendar_event_id) {
                // Update existing event
                try {
                    $updatedEvent = $service->events->update('primary', $booking->google_calendar_event_id, $event);
                    $eventId = $updatedEvent->getId();
                } catch (\Exception $e) {
                    // If event was deleted manually in Google Calendar, re-create it
                    $newEvent = $service->events->insert('primary', $event);
                    $eventId = $newEvent->getId();
                }
            } else {
                // Create new event
                $newEvent = $service->events->insert('primary', $event);
                $eventId = $newEvent->getId();
            }

            $booking->update([
                'google_calendar_event_id' => $eventId,
                'is_synced' => true
            ]);

            return [
                'success' => true,
                'event_id' => $eventId,
                'message' => 'Successfully synced booking to Google Calendar.'
            ];

        } catch (\Exception $e) {
            Log::error("Error syncing Booking #{$booking->id} to Google Calendar: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Google Calendar API Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Disconnects / deletes a booking event from Google Calendar.
     */
    public function disconnect(Booking $booking)
    {
        if (!$booking->google_calendar_event_id) {
            return true;
        }

        $user = $booking->tenant;
        if (!$user) {
            return false;
        }

        $client = $this->getGoogleClientForUser($user);
        if (!$client) {
            return false;
        }

        try {
            $service = new \Google\Service\Calendar($client);
            $service->events->delete('primary', $booking->google_calendar_event_id);

            $booking->update([
                'google_calendar_event_id' => null,
                'is_synced' => false
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Error deleting Google Calendar event for Booking #{$booking->id}: " . $e->getMessage());
            
            // Still clear local reference if Google reports resource is gone
            if ($e->getCode() == 404 || $e->getCode() == 410) {
                $booking->update([
                    'google_calendar_event_id' => null,
                    'is_synced' => false
                ]);
                return true;
            }
            return false;
        }
    }

    /**
     * Imports events from the tenant's Google Calendar to local google_calendar_events.
     */
    public function importGoogleCalendarEvents(User $user)
    {
        $client = $this->getGoogleClientForUser($user);
        if (!$client) {
            throw new \Exception("User is not connected to Google OAuth.");
        }

        try {
            $service = new \Google\Service\Calendar($client);
            $calendarId = 'primary';
            
            $optParams = [
                'maxResults' => 100,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => Carbon::now()->subMonths(3)->toRfc3339String(), // Fetch from 3 months ago onwards
            ];

            $results = $service->events->listEvents($calendarId, $optParams);
            $events = $results->getItems();

            $importedCount = 0;
            $activeGoogleEventIds = [];

            foreach ($events as $event) {
                $start = $event->getStart()->getDateTime() ?? $event->getStart()->getDate();
                $end = $event->getEnd()->getDateTime() ?? $event->getEnd()->getDate();

                if (!$start || !$end) {
                    continue;
                }

                // Parse standard date strings or date-times
                $startTime = Carbon::parse($start);
                $endTime = Carbon::parse($end);

                $localEvent = GoogleCalendarEvent::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'google_event_id' => $event->getId(),
                    ],
                    [
                        'summary' => $event->getSummary() ?? '(No Title)',
                        'description' => $event->getDescription(),
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'status' => $event->getStatus() ?? 'confirmed',
                    ]
                );

                $activeGoogleEventIds[] = $event->getId();
                $importedCount++;
            }

            // Cleanup local events that were deleted on Google Calendar (in the sync time range)
            GoogleCalendarEvent::where('user_id', $user->id)
                ->where('start_time', '>=', Carbon::now()->subMonths(3))
                ->whereNotIn('google_event_id', $activeGoogleEventIds)
                ->delete();

            return $importedCount;

        } catch (\Exception $e) {
            Log::error("Error importing Google Calendar events for User #{$user->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
