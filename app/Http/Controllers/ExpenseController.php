<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Estate;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $expenses = Expense::with(['estate', 'user'])->latest('expense_date')->get();
        return view('expenses.index', compact('expenses', 'role'));
    }

    public function create()
    {
        $estates = Estate::all();
        return view('expenses.create', compact('estates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'category' => 'required|in:operational,maintenance,salary,utility,tax,other',
            'estate_id' => 'nullable|exists:estates,id'
        ]);

        $validated['recorded_by'] = Auth::id();

        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Data pengeluaran dihapus.');
    }
}
