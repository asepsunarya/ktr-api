<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store(AdminRequest $request)
    {
        $admin = Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin' => $admin
        ]);
    }

    public function index()
    {
        $admins = Admin::all();

        return response()->json($admins);
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);

        return response()->json($admin);
    }

    public function update(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $data = [
            'email' => $request->email,
        ];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $admin->update($data);

        return response()->json([
            'message' => 'Admin updated successfully',
            'admin' => $admin
        ]);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return response()->json([
            'message' => 'Admin deleted successfully'
        ]);
    }
}
