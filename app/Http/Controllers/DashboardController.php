<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\SepedaListrik;
use App\Models\Toko;
use Illuminate\Http\Request;

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
}
