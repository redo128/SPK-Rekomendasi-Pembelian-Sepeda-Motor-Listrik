<?php

namespace App\Http\Controllers;

use App\Models\AlternatifSelectPembeli;
use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\SepedaListrik;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SepedaPenjualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id=User::find(Auth::id());
        $data_sepeda=SepedaListrik::where('toko_id',$user_id->toko_id)->get();
        $data_alternatif=AlternatifValue::all();
        // $data_katalog=AlternatifSelectPembeli::all();
        return view('Penjual.sepeda_list',compact('data_sepeda','data_alternatif'));
    }

    public function index_sepeda_listrik()
    {
        $user_id=User::find(Auth::id());
        $index = SepedaListrik::where('tipe',"sepeda listrik")->where('toko_id',$user_id->toko_id)->get();
        $kriteria= Kriteria::all();
        $sepeda = AlternatifValue::all();
        return view('Penjual.sepeda_listrik_list',compact('index','sepeda','kriteria'));
    }
    public function index_sepeda_motor_listrik()
    {
        $user_id=User::find(Auth::id());
        $index = SepedaListrik::where('tipe',"sepeda motor listrik")->where('toko_id',$user_id->toko_id)->get();
        $kriteria= Kriteria::all();
        $sepeda = AlternatifValue::all();
        return view('Penjual.sepeda_listrik_list',compact('index','sepeda','kriteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand=Brand::all();
        $kriteria=Kriteria::all();
        return view('Penjual.sepeda_listrik_create',compact('brand','kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $value = $request->input('value'); 

        //Inputan Sepeda listrik
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('images', 'public');
        }
        $sepeda=new SepedaListrik();
        $kriteria=Kriteria::all();
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->toko_id=Auth::user()->toko_id;
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
        
        return redirect()->route('sepeda_penjual.index');
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
        $brand=Brand::all();
        $kriteria_all=Kriteria::all();
        $value=AlternatifValue::where('alternatif_id',$id)->get();
        return view('Penjual.sepeda_listrik_edit',compact('data','brand','kriteria_all','value'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sepeda=SepedaListrik::find($id);
        $sepeda->nama_sepeda=$request->get('nama_sepeda');
        $sepeda->tipe=$request->get('tipe');
        $sepeda->brand_id=$request->get('brand_id');
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
        return redirect()->route('sepeda_penjual.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=SepedaListrik::find($id);
        $data->delete();
        return redirect()->route('sepeda_penjualindex');
    }
}
