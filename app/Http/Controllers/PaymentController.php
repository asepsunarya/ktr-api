<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Models\KtrRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil dibuat',
            'payment' => $payment->load('ktrRequest')
        ]);
    }

    public function index()
    {
        $payments = Payment::with('ktrRequest')->get();

        return response()->json($payments);
    }

    public function show($id)
    {
        $payment = Payment::with('ktrRequest')->findOrFail($id);

        return response()->json($payment);
    }

    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil diperbarui',
            'payment' => $payment->load('ktrRequest')
        ]);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json([
            'message' => 'Pembayaran berhasil dihapus'
        ]);
    }

    public function getByUserId($userId)
    {
        $payments = Payment::with('ktrRequest')->whereHas('ktrRequest', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        return response()->json($payments);
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'payment_id' => 'required|string',
        ]);

        $payment = Payment::findOrFail($id);

        if ($payment->payment_id !== $request->payment_id) {
            return response()->json([
                'message' => 'Kode pembayaran tidak sesuai',
            ], 400);
        }

        $payment->update([
            'status' => 'paid',
        ]);

        $ktrRequest = KtrRequest::findOrFail($payment->ktr_request_id);
        $ktrRequest->update([
            'status' => 'waiting_approval',
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil diverifikasi',
            'payment' => $payment,
            'ktrRequest' => $ktrRequest,
        ]);
    }
}
