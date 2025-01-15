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
        $payments = Payment::with('ktrRequest.user')->get();

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
/**
     * @OA\Get(
     *     path="/api/payments/user/{userId}",
     *     summary="Ambil List Pembayaran",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getByUserId($userId)
    {
        $payments = Payment::with('ktrRequest.user')->whereHas('ktrRequest', function ($query) use ($userId) {
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

/**
     * @OA\Get(
     *     path="/api/payments/user/{userId}/stats",
     *     summary="Ambil Statistik Pembayaran",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getPaymentStatsByUserId($userId)
    {
        $totalPayments = Payment::whereHas('ktrRequest', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $paidPayments = Payment::whereHas('ktrRequest', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'paid')->count();

        $pendingPayments = Payment::whereHas('ktrRequest', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $failedPayments = Payment::whereHas('ktrRequest', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'failed')->count();

        return response()->json([
            'total_payments' => $totalPayments,
            'paid_payments' => $paidPayments,
            'pending_payments' => $pendingPayments,
            'failed_payments' => $failedPayments,
        ]);
    }

/**
     * @OA\Get(
     *     path="/api/payments/admin/stats",
     *     summary="Ambil Statistik Pembayaran",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getPaymentStats()
    {
        $totalPayments = Payment::count();

        $paidPayments = Payment::where('status', 'paid')->count();

        $pendingPayments = Payment::where('status', 'pending')->count();

        $failedPayments = Payment::where('status', 'failed')->count();

        return response()->json([
            'total_payments' => $totalPayments,
            'paid_payments' => $paidPayments,
            'pending_payments' => $pendingPayments,
            'failed_payments' => $failedPayments,
        ]);
    }
}
