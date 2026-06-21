<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CalendarSyncService;
use App\Models\Booking;
use App\Models\FacilityBooking;
use App\Models\GoogleCalendarEvent;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarSyncService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * Get Google Calendar connection status for the authenticated user.
     */
    public function getStatus(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'connected' => !empty($user->google_refresh_token),
            'email' => $user->google_id ? $user->email : null,
            'token_expires_at' => $user->google_token_expires_at ? $user->google_token_expires_at->toDateTimeString() : null,
            'is_token_expired' => $user->google_token_expires_at ? $user->google_token_expires_at->isPast() : true,
        ]);
    }

    /**
     * Manually trigger Google Calendar event import into the app.
     */
    public function syncImport(Request $request)
    {
        $user = $request->user();

        if (empty($user->google_refresh_token)) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Google belum terhubung. Silakan lakukan integrasi Google OAuth terlebih dahulu.'
            ], 400);
        }

        try {
            $count = $this->calendarService->importGoogleCalendarEvents($user);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menyinkronkan {$count} event dari Google Calendar Anda.",
                'imported_count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor event dari Google: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unified events for the local calendar (Bookings + Facility Bookings + Google Calendar).
     */
    public function getEvents(Request $request)
    {
        $user = $request->user();

        // 1. Fetch Bookings (Sewa Unit)
        $bookings = Booking::with('unit.estate')
            ->where('tenant_id', $user->id)
            ->get()
            ->map(function ($booking) {
                $unitName = $booking->unit->name ?? 'Unit';
                $estateName = $booking->unit->estate->name ?? 'Kawasan';
                return [
                    'id' => 'booking_' . $booking->id,
                    'source' => 'app_booking',
                    'title' => 'Sewa: ' . $unitName . ' (' . $estateName . ')',
                    'description' => "Status Booking: " . ucfirst($booking->status) . "\nDurasi: {$booking->duration_months} Bulan",
                    'start' => $booking->start_date . 'T00:00:00',
                    'end' => $booking->end_date . 'T23:59:59',
                    'color' => '#b75c1c', // Brand primary (Brownish orange)
                    'is_all_day' => true,
                    'editable' => false,
                    'details' => [
                        'booking_id' => $booking->id,
                        'unit_name' => $unitName,
                        'estate_name' => $estateName,
                        'status' => $booking->status,
                        'payment_type' => $booking->payment_type
                    ]
                ];
            });

        // 2. Fetch Facility Bookings
        $facilityBookings = FacilityBooking::with('facility')
            ->where('tenant_id', $user->id)
            ->get()
            ->map(function ($fb) {
                $facilityName = $fb->facility->name ?? 'Fasilitas';
                $bookingDate = $fb->booking_date; // e.g. Y-m-d
                
                // Format H:i to H:i:s
                $startTime = str_contains($fb->start_time, ':') ? $fb->start_time : $fb->start_time . ':00';
                $endTime = str_contains($fb->end_time, ':') ? $fb->end_time : $fb->end_time . ':00';
                
                return [
                    'id' => 'facility_booking_' . $fb->id,
                    'source' => 'app_facility_booking',
                    'title' => 'Fasilitas: ' . $facilityName,
                    'description' => "Reservasi {$facilityName}\nStatus: " . ucfirst($fb->status) . "\nJumlah Tamu: {$fb->guest_count} orang",
                    'start' => $bookingDate . 'T' . $startTime,
                    'end' => $bookingDate . 'T' . $endTime,
                    'color' => '#3e342f', // Dark accent color
                    'is_all_day' => false,
                    'editable' => false,
                    'details' => [
                        'facility_booking_id' => $fb->id,
                        'facility_name' => $facilityName,
                        'status' => $fb->status,
                        'guest_count' => $fb->guest_count
                    ]
                ];
            });

        // 3. Fetch Google Calendar Events
        $googleEvents = GoogleCalendarEvent::where('user_id', $user->id)
            ->get()
            ->map(function ($ge) {
                return [
                    'id' => 'google_event_' . $ge->id,
                    'source' => 'google_calendar',
                    'title' => '[Google] ' . $ge->summary,
                    'description' => $ge->description ?? 'Tidak ada deskripsi.',
                    'start' => $ge->start_time->toIso8601String(),
                    'end' => $ge->end_time->toIso8601String(),
                    'color' => '#4285F4', // Google Blue
                    'is_all_day' => false,
                    'editable' => false,
                    'details' => [
                        'google_event_id' => $ge->google_event_id,
                        'status' => $ge->status
                    ]
                ];
            });

        // Merge all event collections
        $allEvents = $bookings->concat($facilityBookings)->concat($googleEvents);

        return response()->json([
            'success' => true,
            'events' => $allEvents
        ]);
    }
}
