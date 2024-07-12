<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\SepedaListrik;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $data_sepeda=SepedaListrik::count();
        $data_toko=Toko::count();
        $data_brand=Brand::count();
        $kriteria_all=Kriteria::all();
        $sepeda_lastest = SepedaListrik::latest()->take(5)->get();
        $sepeda_value=AlternatifValue::all();
        return view('Pembeli.beranda',compact('data_sepeda','data_toko','data_brand','kriteria_all','sepeda_lastest','sepeda_value'));
    }
    public function index_sa(){
        $data_sepeda=SepedaListrik::count();
        $data_toko=Toko::count();
        $data_brand=Brand::count();
        $kriteria_all=Kriteria::all();
        $sepeda_lastest = SepedaListrik::latest()->take(5)->get();
        $sepeda_value=AlternatifValue::all();
        return view('Superadmin.beranda',compact('data_sepeda','data_toko','data_brand','kriteria_all','sepeda_lastest','sepeda_value'));
    }
    public function index_penjual(){
        $admin_toko=User::find(Auth::id());
        $data_sepeda=SepedaListrik::where('toko_id',$admin_toko->toko_id)->count();
        $data_brand=Brand::count();
        $kriteria_all=Kriteria::all();
        $sepeda_lastest = SepedaListrik::latest()->take(5)->get();
        $sepeda_value=AlternatifValue::all();
        return view('Penjual.beranda',compact('data_sepeda','data_toko','data_brand','kriteria_all','sepeda_lastest','sepeda_value'));
    }
    public function rangkuman(){
        return view('rangkuman');
    }
}
