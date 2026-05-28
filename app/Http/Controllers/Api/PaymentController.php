<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Activity;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handleNotification(Request $request)
    {
        $merchantCode = env('DUITKU_MERCHANT_CODE');
        $apiKey = env('DUITKU_API_KEY');

        // DEVELOPER BYPASS: For Local Development / Final Project Demo
        if (config('app.env') === 'local' && $request->input('simulate')) {
            $orderId = $request->input('order_id');
            $parts = explode('-', $orderId);
            $billingId = $parts[1];
            $billing = Billing::find($billingId);
            if ($billing) {
                $this->markAsPaid($billing, $request->input('gross_amount'));
                $billing->save();
                return response()->json(['status' => 'success', 'message' => 'DEVELOPER BYPASS: Status updated to PAID']);
            }
        }

        try {
            $amount = $request->input('amount');
            $merchantOrderId = $request->input('merchantOrderId');
            $signature = $request->input('signature');
            $resultCode = $request->input('resultCode');

            if(!empty($merchantCode) && !empty($amount) && !empty($merchantOrderId) && !empty($signature)) {
                $calcSignature = md5($merchantCode . $amount . $merchantOrderId . $apiKey);

                if($signature == $calcSignature) {
                    $parts = explode('-', $merchantOrderId);
                    $billingId = $parts[1] ?? null;
                    $billing = Billing::find($billingId);

                    if (!$billing) {
                        return response()->json(['message' => 'Billing not found'], 404);
                    }

                    if($resultCode == "00") {
                        // Success
                        $this->markAsPaid($billing, $amount);
                    } else if($resultCode == "01") {
                        // Failed
                        $billing->status = 'unpaid';
                    }

                    $billing->save();
                    return response()->json(['status' => 'success']);
                } else {
                    return response()->json(['message' => 'Bad Signature'], 400);
                }
            } else {
                return response()->json(['message' => 'Bad Parameter'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    private function markAsPaid($billing, $amountPaid)
    {
        $billing->paid_amount += $amountPaid;
        
        if ($billing->paid_amount >= $billing->amount) {
            $billing->status = 'paid';
        } else {
            $billing->status = 'partial';
        }

        Activity::create([
            'user_id' => $billing->tenant->id ?? null,
            'action' => 'Payment Settled (Duitku)',
            'description' => "Received IDR " . number_format($amountPaid) . " for Billing #{$billing->id}",
        ]);
    }
}
