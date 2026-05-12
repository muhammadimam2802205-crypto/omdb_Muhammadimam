<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Tampilkan halaman register
    public function register()
    {
        return view('auth.register');
    }

    // Tampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses registrasi
    public function register_process(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ]
        ]);

        try {
            $response = $this->authService->register($validated);

            if (!$response) {
                return redirect()->back()->with('error', 'Registrasi gagal');
            }

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

        } catch (\Throwable $th) {
            Log::error([
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()->with('error', 'Registrasi gagal: ' . $th->getMessage());
        }
    }

    // Proses login
    public function login_process(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
            ],
            'password' => [
                'required',
            ],
        ], [
            // Pesan error custom
            'email.required'  => 'Email wajib diisi.',
            'email.email'     => 'Format email tidak valid.',
            'email.exists'    => 'Email tidak terdaftar.',
            'password.required' => 'Password wajib diisi.',
        ]);

        try {
            $response = $this->authService->login([
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            if (!$response) {
                return redirect()->back()
                    ->with('error', 'Password yang Anda masukkan salah.')
                    ->withInput();
            }

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');

        } catch (\Throwable $th) {
            Log::error([
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Login gagal: ' . $th->getMessage())
                ->withInput();
        }
    }
      public function logout()
    {
        try {
            session()->flush();

            return redirect()->route('login')->with('success', 'Anda telah keluar');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Failted register user", [
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'message' => $th->getMessage()
            ]);
            return redirect()->back()->with('error', 'Terjadi keselahan');
        }
    }
}