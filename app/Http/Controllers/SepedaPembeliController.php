<?php

namespace App\Http\Controllers;

use App\Models\AlternatifSelectPembeli;
use App\Models\AlternatifValue;
use App\Models\SepedaListrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SepedaPembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_sepeda=SepedaListrik::all();
        $data_alternatif=AlternatifValue::all();
        $data_katalog=AlternatifSelectPembeli::all();
        return view('Pembeli.sepeda_list',compact('data_sepeda','data_alternatif','data_katalog'));
    }
    public function index_sepeda_listrik()
    {
        $data_sepeda=SepedaListrik::where('tipe','sepeda listrik')->get();
        $data_alternatif=AlternatifValue::all();
        $data_katalog=AlternatifSelectPembeli::all();
        return view('Pembeli.sepeda_listrik_list',compact('data_sepeda','data_alternatif','data_katalog'));
    }
    public function index_sepeda_motor_listrik()
    {
        $data_sepeda=SepedaListrik::where('tipe','sepeda motor listrik')->get();
        $data_alternatif=AlternatifValue::all();
        $data_katalog=AlternatifSelectPembeli::all();
        return view('Pembeli.sepeda_motor_listrik_list',compact('data_sepeda','data_alternatif','data_katalog'));
    }

    public function custom_store_sepeda_motor_listrik(string $id)
    {
        $data=new AlternatifSelectPembeli;
        $data->alternatif_id=$id;
        $data->user_id=Auth::user()->id;
        $data->save();
        return redirect()->route('list_sepeda_motor_listrik');
    }
    public function custom_store_sepeda_listrik(string $id)
    {
        $data=new AlternatifSelectPembeli;
        $data->alternatif_id=$id;
        $data->user_id=Auth::user()->id;
        $data->save();
        return redirect()->route('list_sepeda_listrik');
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
