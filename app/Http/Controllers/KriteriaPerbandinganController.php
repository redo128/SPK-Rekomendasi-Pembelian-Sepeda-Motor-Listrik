<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaPerbandingan;
use Illuminate\Http\Request;

class KriteriaPerbandinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index=Kriteria::all();
        // dd($index);
        // $temp=KriteriaPerbandingan::all();
        // $temp=KriteriaPerbandingan::where('kriteria_1',1)->count();
        // dd($temp);
        $simpan=array();
        foreach($index as $a => $text){
        $temp=KriteriaPerbandingan::where('kriteria_1',$text->id)->get();
         foreach($temp as $a2 => $text2){
            $simpan["kriteria-".$a][$a2]=$text2->rating;
         }
        
        }
// dump($simpan->id);
        // dd($simpan["kriteria-0"]);
        // foreach($simpan["kriteria-0"] as $tes){
        //     dd($tes);
        // }
        // dd($simpan["kriteria-0"][4]);
        // if($simpan["kriteria-0"][3]==null){
        //     dd("Kosong");
        // }else{
        //     dd("ada");
        // }
        // if(isset($simpan["kriteria-0"][4])){

        //    dd("ada");
        
        // }else{
        
        //     dd("gaada");
        
        // }
        // if(isset($test)){

        //    dd("ada");
        
        // }else{
        
        //     dd("gaada");
        
        // }
        
        return view('SuperAdmin.kriteria_perbandingan_index',compact('simpan','index'));
        
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
        // dd("TEST");
        $index=Kriteria::all();
        // dd($index);
        $dataperbandingan=KriteriaPerbandingan::where('kriteria_1',$id);
        $find=Kriteria::find($id);
        return view('SuperAdmin.kriteria_perbandingan_edit',compact('index','dataperbandingan','find'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rating = $request->input('rating'); 
        // dd($rating);
        // dd($id);
        $kriteria=Kriteria::all();
        foreach($kriteria as $loop){
            // $dataperbandingan=KriteriaPerbandingan::where("kriteria_1",$id)->where("kriteria_2",$loop->id)->first();
            if(KriteriaPerbandingan::where("kriteria_1",$id)->where("kriteria_2",$loop->id)->exists()){
            $dataperbandingan=KriteriaPerbandingan::where("kriteria_1",$id)->where("kriteria_2",$loop->id)->first();
                $dataperbandingan->rating=$rating[$id][$loop->id];
                // dd($dataperbandingan);
                $dataperbandingan->save();
            }else{
                $dataperbandingan=new KriteriaPerbandingan;
                $dataperbandingan->kriteria_1=$id;
                $dataperbandingan->kriteria_2=$loop->id;
                $dataperbandingan->rating=$rating[$id][$loop->id];
                $dataperbandingan->save();
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
