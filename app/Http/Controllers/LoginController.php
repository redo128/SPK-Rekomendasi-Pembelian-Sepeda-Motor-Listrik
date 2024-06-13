<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;

class LoginController extends Controller
{
    function index(){
        return view('login');
    }
    function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required'=>'email wajib diisi',
            'password.required'=>'password wajib diisi'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $request->session()->regenerate();
            if(Auth::user()->role=='superadmin'){
                return redirect()->route('SuperAdmin.beranda');
            }elseif(Auth::user()->role=='penjual'){
                return redirect()->route('penjual.index');
            }elseif(Auth::user()->role=='pembeli'){
                return redirect()->route('pembeli.index');
            }
        }else{
                            // return redirect('')->withErrors('Email dan Password tidak ada');
            return back()->withErrors('Email dan Password tidak ada');
        }
    }
    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    function login_auth(){
        if (Auth::check()) {
            // Pengguna sudah terautentikasi, lakukan pengecekan tambahan
            $user = Auth::user();
            // Pengecekan apakah pengguna memiliki peran tertentu
            if ($user->role=='superadmin') {
                // Lakukan tindakan untuk pengguna dengan peran superadmin
                return redirect()->route('SuperAdmin.beranda');
            } elseif ($user->role=='penjual') {
                // Lakukan tindakan untuk pengguna dengan peran penjual
                return redirect()->route('penjual.index');
            }
             elseif ($user->role=='pembeli') {
                // Lakukan tindakan untuk pengguna dengan peran pembeli
                return redirect()->route('pembeli.index');
            } else {
                return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            // Pengguna belum terautentikasi, arahkan ke halaman login
            return redirect()->route('login');
        }
    }
}
