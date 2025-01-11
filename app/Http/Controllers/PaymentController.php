<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil dibuat',
            'payment' => $payment
        ]);
    }

    public function index()
    {
        $payments = Payment::all();

        return response()->json($payments);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return response()->json($payment);
    }

    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->validated());

        return response()->json([
            'message' => 'Pembayaran berhasil diperbarui',
            'payment' => $payment
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
}
