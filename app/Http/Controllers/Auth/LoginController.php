<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->level == 'pengguna'){
                return redirect()->route('page.diagnosa');
            } else {
                return redirect()->route('gejala.index');
            }
        }
 
        return back()->withErrors([
            'message' => 'nama atau password salah',
        ]);
    }
}
