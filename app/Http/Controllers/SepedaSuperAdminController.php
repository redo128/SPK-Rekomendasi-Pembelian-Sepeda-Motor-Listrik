<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\SepedaListrik;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SepedaSuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = SepedaListrik::all();
        $columns = DB::getSchemaBuilder()->getColumnListing('sepeda_listrik');
        return view('Superadmin.sepeda_listrik_index',compact('index','columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $toko=Toko::all();
        $brand=Brand::all();
        $kriteria=Kriteria::all();
        return view('SuperAdmin.sepeda_listrik_create',compact('toko','brand','kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->get('harga'));
        $sepeda=new SepedaListrik();
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->toko_id=$request->get('toko_id');
        $sepeda->brand_id=$request->get('brand_id');
        $sepeda->save();
        return redirect()->route('sepeda_sa.index');
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
        $data=SepedaListrik::find($id);
        $toko=Toko::all();
        $brand=Brand::all();
        return view('Superadmin.sepeda_listrik_edit',compact('data','toko','brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validated = $request->validate([
        //     'nama_toko' => 'required|unique:Toko,nama_toko,'.$id,'|max:255',
        // ],[
        //     'nama_toko.unique'=>'This Brand Name Already Taken',
            
        // ]);
        $sepeda=SepedaListrik::find($id);
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->toko_id=$request->get('toko_id');
        $sepeda->brand_id=$request->get('brand_id');
        $sepeda->save();
        return redirect()->route('sepeda_sa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand=SepedaListrik::find($id);
        $brand->delete();
        return redirect()->route('sepeda_sa.index');
    }
}
