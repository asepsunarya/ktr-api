<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Handle login request.
     */
    public function login(LoginRequest $request)
    {
        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Berhasil login
            Auth::login($user); // Login user ke session
            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah',
        ], 401);
    }

    /**
     * Handle login request.
     */
    public function loginAdmin(LoginAdminRequest $request)
    {
        // Ambil admin berdasarkan email
        $admin = Admin::where('email', $request->email)->first();

        // Cek apakah admin ditemukan dan password cocok
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Berhasil login
            Auth::login($admin); // Login admin ke session
            return response()->json([
                'message' => 'Login berhasil',
                'admin' => $admin
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah',
        ], 401);
    }

    /**
     * Handle registration request.
     */
    public function register(RegisterRequest $request)
    {
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'ktp' => $request->ktp,
            'phone' => $request->phone,
            'password' => bcrypt($request->password), // Hash password
        ]);

        // Login user setelah registrasi (opsional)
        Auth::login($user);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user
        ]);
    }

    /**
     * Handle logout request.
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
