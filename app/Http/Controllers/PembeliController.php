<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembeliController extends Controller
{
    function index(){
        $namauser=Auth::user()->name;
        return view('Pembeli.beranda',compact('namauser'));
    }
}
