<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Unit;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::with('interestedUnit')->latest()->get();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('leads.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'interested_unit_id' => 'nullable|exists:units,id',
            'status' => 'required|in:lead,survey,negotiation,deal,lost',
            'survey_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Lead::create($validated);
        return redirect()->route('leads.index')->with('success', 'Calon penyewa berhasil didaftarkan.');
    }

    public function edit(Lead $lead)
    {
        $units = Unit::all();
        return view('leads.edit', compact('lead', 'units'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'interested_unit_id' => 'nullable|exists:units,id',
            'status' => 'required|in:lead,survey,negotiation,deal,lost',
            'survey_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $lead->update($validated);
        return redirect()->route('leads.index')->with('success', 'Data calon penyewa diperbarui.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Calon penyewa dihapus.');
    }
}
