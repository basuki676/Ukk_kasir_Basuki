<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function ViewRegister()
    {
        return view('register');
    }

    // Menangani proses registrasi
    public function CreateRegister(Request $request)
    {
        // Validasi inputan dari pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // pastikan ada konfirmasi password
        ]);

        // Membuat user baru dan menyimpannya ke database
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = 'employe'; // Role default untuk user baru
        $user->save();

        // Redirect ke halaman login setelah berhasil registrasi
        return redirect()->route('login.view');
    }

    // Menampilkan halaman login
    public function ViewLogin()
    {
        return view('login');
    }

    // Menangani proses login
    public function AuthLogin(Request $request)
    {
        // Validasi inputan login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $data = $request->only('email', 'password');

        // Mencoba login dengan menggunakan email dan password yang dimasukkan
        if (Auth::attempt($data)) {
            $request->session()->regenerate(); // Regenerasi session setelah login berhasil
            return redirect('/'); // Redirect ke halaman produk setelah login berhasil
        } else {
            return redirect()->back()->with('error', 'Email atau password salah'); // Menampilkan pesan error jika login gagal
        }
    }

    // Menangani proses logout
    public function logout()
    {
        Auth::logout(); // Logout user
        return redirect()->route('login.view'); // Redirect ke halaman login setelah logout
    }
}
