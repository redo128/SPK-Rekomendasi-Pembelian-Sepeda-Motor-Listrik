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
            // $namauser=Auth::user()->name;
        // return view('sukses',compact('namauser'));
        $request->session()->regenerate();
        if(Auth::user()->role=='superadmin'){
            return redirect()->route('SuperAdmin.beranda');
        }elseif(Auth::user()->role=='penjual'){
            return redirect()->route('Penjual.beranda');
        }elseif(Auth::user()->role=='pembeli'){
            return redirect()->route('pembeli.index');
        }
        }
        else{
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
}
