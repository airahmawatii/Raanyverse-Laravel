<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;


class BillingController extends Controller
{

    public function index()
    {
        $billings = Billing::with(['tenant', 'unit'])->orderBy('created_at', 'desc')->paginate(10);
        $tenants = User::where('role', 'tenant')->get();
        $units = Unit::all();
        return view('billings.index', compact('billings', 'tenants', 'units'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }
        $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric',
            'period' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Billing::create(array_merge($request->only([
            'tenant_id', 'unit_id', 'amount', 'period', 'due_date'
        ]), ['admin_fee' => 10000, 'platform_fee' => 2500, 'paid_amount' => 0, 'status' => 'unpaid']));
        
        return redirect()->route('billings.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function update(Request $request, Billing $billing)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }
        $request->validate([
            'status' => 'required|in:unpaid,paid,overdue',
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'paid') {
            $data['paid_amount'] = $billing->amount;
        }

        $billing->update($data);
        
        return redirect()->route('billings.index')->with('success', 'Status tagihan diperbarui.');
    }

    public function export()
    {
        if (auth()->user()->role === 'tenant') {
            abort(403);
        }

        $billings = Billing::with(['tenant', 'unit'])->get();
        $csvFileName = 'laporan_tagihan_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Penyewa', 'Unit', 'Periode', 'Jumlah', 'Terbayar', 'Jatuh Tempo', 'Status'];

        $callback = function() use($billings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($billings as $bill) {
                fputcsv($file, [
                    $bill->tenant->name,
                    $bill->unit->name,
                    $bill->period,
                    $bill->amount,
                    $bill->paid_amount,
                    $bill->due_date,
                    $bill->status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadReceipt(Billing $billing)
    {
        if ($billing->status !== 'paid') {
            abort(403, 'Hanya tagihan lunas yang dapat diunduh kuitansinya.');
        }

        // Allow tenant of this billing, or admin, or owner to download the receipt
        if (auth()->user()->role === 'tenant' && $billing->tenant_id !== auth()->id()) {
            abort(403);
        }

        $billing->load(['tenant', 'unit']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billings.receipt', compact('billing'));
        return $pdf->download('kuitansi-' . $billing->id . '.pdf');
    }

    public function verifyReceipt(Billing $billing)
    {
        $billing->load(['tenant', 'unit']);
        return view('billings.verify', compact('billing'));
    }
}
