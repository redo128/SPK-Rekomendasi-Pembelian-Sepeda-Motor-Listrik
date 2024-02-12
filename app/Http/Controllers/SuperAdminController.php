<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SuperAdminController extends Controller
{
    function index(){
        return view('SuperAdmin.beranda');
    }
    function penentuan_bobot(){
        $namauser=Auth::user()->name;
        return view('Superadmin.bobot',compact('namauser'));
    }
    public function toko_store(Request $request): RedirectResponse
    {
        $toko = $request->name;
 
        // Store the user...
 
        return redirect('/users');
    }
    function toko_edit(){

    }
    function toko_delete(){

    }
}
