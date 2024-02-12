<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualController extends Controller
{
    function index(){
        $namauser=Auth::user()->name;
        return view('Penjual.beranda',compact('namauser'));
    }
}
