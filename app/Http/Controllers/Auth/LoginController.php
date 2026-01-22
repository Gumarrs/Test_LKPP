<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 1. HAPUS method showLoginForm() yang tadi kita buat.
    // Biarkan Laravel pakai view default-nya, kita tidak butuh kirim $num1/$num2 lagi.
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. UPDATE VALIDASI LOGIN
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            // Gunakan aturan 'captcha' bawaan library
            'captcha' => 'required|captcha', 
        ], [
            // Pesan Error Custom
            'captcha.required' => 'Kode keamanan wajib diisi.',
            'captcha.captcha' => 'Kode keamanan salah. Silakan coba lagi.',
        ]);
    }
}