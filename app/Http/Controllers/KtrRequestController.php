<?php

namespace App\Http\Controllers;

use App\Http\Requests\KtrRequestRequest;
use App\Models\KtrRequest;
use Illuminate\Http\Request;

class KtrRequestController extends Controller
{
    public function store(KtrRequestRequest $request)
    {
        $ktrRequest = KtrRequest::create($request->validated());

        return response()->json([
            'message' => 'Permohonan KTR berhasil dibuat',
            'ktrRequest' => $ktrRequest
        ]);
    }

    public function index()
    {
        $ktrRequests = KtrRequest::all();

        return response()->json($ktrRequests);
    }

    public function show($id)
    {
        $ktrRequest = KtrRequest::findOrFail($id);

        return response()->json($ktrRequest);
    }

    public function update(KtrRequestRequest $request, $id)
    {
        $ktrRequest = KtrRequest::findOrFail($id);
        $ktrRequest->update($request->validated());

        return response()->json([
            'message' => 'Permohonan KTR berhasil diperbarui',
            'ktrRequest' => $ktrRequest
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
}
