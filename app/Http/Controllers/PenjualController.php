<?php

namespace App\Http\Controllers;

use App\Models\AlternatifSelectPembeli;
use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\SepedaListrik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_toko=User::find(Auth::id());
        $data_sepeda_listrik=SepedaListrik::where('toko_id',$admin_toko->toko_id)->where('tipe','sepeda listrik')->count();
        $data_sepeda_motor_listrik=SepedaListrik::where('toko_id',$admin_toko->toko_id)->where('tipe','sepeda motor listrik')->count();
        $data_brand=Brand::count();
        $kriteria_all=Kriteria::all();
        $sepeda_lastest = SepedaListrik::where('toko_id',$admin_toko->toko_id)->latest()->take(5)->get();
        $sepeda_value=AlternatifValue::all();
        return view('Penjual.beranda',compact('data_sepeda_listrik','data_sepeda_motor_listrik','data_brand','kriteria_all','sepeda_lastest','sepeda_value'));
    }

    public function wishlist_pembeli()
    {
        $data=AlternatifSelectPembeli::all();
        $items=array();
        $admin_toko=User::find(Auth::id());
        foreach($data as $d){
            if($d->sepeda->toko_id == $admin_toko->toko_id){
                if(isset($items[$d->sepeda->id]["value"])){
                    $items[$d->sepeda->id]["value"]+=1;
                }else{
                    $items[$d->sepeda->id]["value"]=0;
                    $items[$d->sepeda->id]["id"]=$d->sepeda->id;
                    $items[$d->sepeda->id]["value"]+=1;
                }
            }
        }
        // $items[6]["value"]+=3;
        $data_sepeda=SepedaListrik::all();
        $kriteria_all=Kriteria::all();
        $filter=collect($items)->sortByDesc("value")->values()->all();
        $data_sepeda_value=AlternatifValue::all();
        return view('penjual.wishlist-pembeli',compact('filter','data_sepeda','kriteria_all','data_sepeda_value'));
       }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
