<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
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
        $kriteria= Kriteria::all();
        // $columns = DB::getSchemaBuilder()->getColumnListing('sepeda_listrik');
        $sepeda = AlternatifValue::all();
        return view('Superadmin.sepeda_listrik_index',compact('index','sepeda','kriteria'));
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
        // dd($request->get('harga'));
        $value = $request->input('value'); 
        // dd($request->image);
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('images', 'public');
        }
        //Inputan Sepeda listrik
        $sepeda=new SepedaListrik();
        $kriteria=Kriteria::all();
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->toko_id=$request->get('toko_id');
        $sepeda->brand_id=$request->get('brand_id');
        $sepeda->image=$filePath;
        $sepeda->save();
        // dd($sepeda->id);
        //Inputan Spesifikasi Sepeda Listrik
        foreach($kriteria as $loop){
            $speksifikasi=new AlternatifValue();
            $speksifikasi->kriteria_id=$loop->id;
            $speksifikasi->alternatif_id=$sepeda->id;
            if($loop->nama_kriteria=="harga"){
                $harga=str_replace(".", "", $value[$loop->nama_kriteria]);
                // dd($harga);
                $speksifikasi->value=$harga;
            }else{
            $speksifikasi->value=$value[$loop->nama_kriteria];
            }
            $speksifikasi->save();
        }
        
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
        $kriteria_all=Kriteria::all();
        $value=AlternatifValue::where('alternatif_id',$id)->get();
        return view('Superadmin.sepeda_listrik_edit',compact('data','toko','brand','value','kriteria_all'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('images', 'public');
        }
        $sepeda=SepedaListrik::find($id);
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->toko_id=$request->get('toko_id');
        $sepeda->brand_id=$request->get('brand_id');
        $sepeda->image=$filePath;
        $kriteria_all=Kriteria::all();
        $kriteria = $request->input('kriteria'); 

        foreach($kriteria_all as $index => $loop_k){
            
            $sepeda_value=AlternatifValue::where('alternatif_id',$id)->where('kriteria_id',$loop_k->id)->first();
            if($loop_k->nama_kriteria=="harga"){
                $harga=str_replace(".", "", $kriteria[$loop_k->nama_kriteria]);
                // dd($harga);
                $sepeda_value->value=$harga;
            }else{
            $sepeda_value->value=$kriteria[$loop_k->nama_kriteria];
            }
            $sepeda_value->save();

        }
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
