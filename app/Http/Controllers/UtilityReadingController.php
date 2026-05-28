<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilityReading;
use App\Models\Unit;
use App\Models\Billing;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class UtilityReadingController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $readings = UtilityReading::with('unit')->latest()->get();
        return view('utility_readings.index', compact('readings', 'role'));
    }

    public function create()
    {
        $units = Unit::where('status', 'occupied')->get();
        return view('utility_readings.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'utility_type' => 'required|in:electricity,water',
            'current_reading' => 'required|numeric|min:0',
            'rate_per_unit' => 'required|numeric|min:0',
            'reading_period' => 'required|string|max:7', // Format: YYYY-MM
        ]);

        // Get previous reading (latest reading of this unit and type)
        $latestReading = UtilityReading::where('unit_id', $validated['unit_id'])
            ->where('utility_type', $validated['utility_type'])
            ->latest()
            ->first();

        $previousReading = $latestReading ? $latestReading->current_reading : 0;
        
        if ($validated['current_reading'] < $previousReading) {
            return back()->withErrors(['current_reading' => 'Meteran baru tidak boleh lebih kecil dari meteran sebelumnya (' . $previousReading . ').']);
        }

        $usageAmount = $validated['current_reading'] - $previousReading;
        $totalCost = $usageAmount * $validated['rate_per_unit'];

        $reading = UtilityReading::create([
            'unit_id' => $validated['unit_id'],
            'utility_type' => $validated['utility_type'],
            'previous_reading' => $previousReading,
            'current_reading' => $validated['current_reading'],
            'usage_amount' => $usageAmount,
            'rate_per_unit' => $validated['rate_per_unit'],
            'total_cost' => $totalCost,
            'reading_period' => $validated['reading_period']
        ]);

        // Find active tenant for this unit to auto-generate billing
        $rental = Rental::where('unit_id', $validated['unit_id'])->first();
        
        if ($rental) {
            Billing::create([
                'tenant_id' => $rental->tenant_id,
                'amount' => $totalCost,
                'due_date' => now()->addDays(7)->toDateString(),
                'status' => 'unpaid',
                'description' => 'Tagihan Utilitas ' . ucfirst($validated['utility_type']) . ' Periode ' . $validated['reading_period'] . ' (' . $usageAmount . ' unit)'
            ]);
        }

        return redirect()->route('utility_readings.index')->with('success', 'Pencatatan utilitas disimpan dan tagihan otomatis terbit.');
    }

    public function destroy(UtilityReading $utilityReading)
    {
        $utilityReading->delete();
        return redirect()->route('utility_readings.index')->with('success', 'Pencatatan utilitas dihapus.');
    }
}
