<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function store(SettingRequest $request)
    {
        $setting = Setting::create($request->validated());

        return response()->json([
            'message' => 'Setting created successfully',
            'setting' => $setting
        ]);
    }

    public function index()
    {
        $settings = Setting::all();

        return response()->json($settings);
    }

    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return response()->json($setting);
    }

    public function update(SettingRequest $request, $id)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->validated());

        return response()->json([
            'message' => 'Setting updated successfully',
            'setting' => $setting
        ]);
    }

    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        return response()->json([
            'message' => 'Setting deleted successfully'
        ]);
    }
}
