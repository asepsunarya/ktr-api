<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtrRequestRequest;
use App\Models\KtrRequest;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KtrRequestController extends Controller
{
    public function store(KtrRequestRequest $request)
    {
        // Upload files
        $ktpFilePath = $request->file('ktp_file')->store('ktp_files', 'public');
        $landDocumentPath = $request->file('land_document')->store('land_documents', 'public');
        $activityLocationPath = $request->file('activity_location')->store('activity_locations', 'public');

        // Create KtrRequest
        $ktrRequest = KtrRequest::create([
            'user_id' => $request->user_id,
            'job' => $request->job,
            'address' => $request->address,
            'act_as' => $request->act_as,
            'road' => $request->road,
            'subdistrict_id' => $request->subdistrict_id,
            'district_id' => $request->district_id,
            'regency_id' => $request->regency_id,
            'land_area' => $request->land_area,
            'land_status' => $request->land_status,
            'purpose' => $request->purpose,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'ktp_file' => $ktpFilePath,
            'land_document' => $landDocumentPath,
            'activity_location' => $activityLocationPath,
            'sign' => $request->sign,
        ]);

        // Ambil total_cost dari tabel settings dengan key 'cost'
        $setting = Setting::where('key', 'cost')->first();
        $totalCost = $setting ? $setting->value : 0;

        // Buat payment baru terkait dengan KtrRequest yang baru dibuat
        $payment = Payment::create([
            'ktr_request_id' => $ktrRequest->id,
            'total_cost' => $totalCost,
            'payment_id' => uniqid(), // Atau gunakan metode lain untuk menghasilkan ID pembayaran
            'status' => 'pending', // Status awal pembayaran
        ]);

        return response()->json([
            'message' => 'Permohonan KTR berhasil dibuat',
            'ktrRequest' => $ktrRequest->load('user'),
            'payment' => $payment
        ]);
    }

/**
     * @OA\Get(
     *     path="/api/ktr-requests",
     *     summary="Ambil List Permohonan Admin",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        $ktrRequests = KtrRequest::with('user')->get();

        return response()->json($ktrRequests);
    }

/**
     * @OA\Get(
     *     path="/api/ktr-requests/{id}",
     *     summary="Ambil Detail Permohonan",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="KTR Request ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id)
    {
        $ktrRequest = KtrRequest::with('user')->with('regency')->with('district')->with('subdistrict')->findOrFail($id);

        return response()->json($ktrRequest);
    }

    public function update(KtrRequestRequest $request, $id)
    {
        $ktrRequest = KtrRequest::findOrFail($id);
        $ktrRequest->update($request->validated());

        return response()->json([
            'message' => 'Permohonan KTR berhasil diperbarui',
            'ktrRequest' => $ktrRequest->load('user')
        ]);
    }

    public function destroy($id)
    {
        $ktrRequest = KtrRequest::findOrFail($id);
        $ktrRequest->delete();

        return response()->json([
            'message' => 'Permohonan KTR berhasil dihapus'
        ]);
    }

    public function getByUserId($userId)
    {
        $ktrRequests = KtrRequest::with('user')->where('user_id', $userId)->get();

        return response()->json($ktrRequests);
    }
/**
     * @OA\Get(
     *     path="/api/ktr-requests/user/{user_id}/stats",
     *     summary="Ambil Statistik Permohonan User",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getRequestStatsByUserId($userId)
    {
        $totalRequests = KtrRequest::where('user_id', $userId)->count();
        $approvedRequests = KtrRequest::where('user_id', $userId)->where('status', 'approved')->count();
        $rejectedRequests = KtrRequest::where('user_id', $userId)->where('status', 'rejected')->count();
        $pendingRequests = KtrRequest::where('user_id', $userId)->where('status', 'pending')->count();

        return response()->json([
            'total_requests' => $totalRequests,
            'approved_requests' => $approvedRequests,
            'rejected_requests' => $rejectedRequests,
            'pending_requests' => $pendingRequests,
        ]);
    }

/**
     * @OA\Get(
     *     path="/api/ktr-requests/admin/stats",
     *     summary="Ambil Statistik Permohonan Admin",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getRequestStats()
    {
        $totalRequests = KtrRequest::count();
        $approvedRequests = KtrRequest::where('status', 'approved')->count();
        $rejectedRequests = KtrRequest::where('status', 'rejected')->count();
        $pendingRequests = KtrRequest::where('status', 'pending')->count();

        return response()->json([
            'total_requests' => $totalRequests,
            'approved_requests' => $approvedRequests,
            'rejected_requests' => $rejectedRequests,
            'pending_requests' => $pendingRequests,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $ktrRequest = KtrRequest::findOrFail($id);
        $ktrRequest->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Status permohonan KTR berhasil diperbarui',
            'ktrRequest' => $ktrRequest,
        ]);
    }
}
