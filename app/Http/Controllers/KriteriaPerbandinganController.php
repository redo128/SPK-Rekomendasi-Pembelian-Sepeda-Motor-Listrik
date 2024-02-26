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
        //Panggil Perbandingan antar kriteria
        $simpan=array();
        $total_per_kolom=array();
        foreach($index as $a => $text){
        $temp=KriteriaPerbandingan::where('kriteria_1',$text->id)->get();
         foreach($temp as $a2 => $text2){
            $simpan["kriteria-".$a][$a2]=$text2->rating;
            if(isset($total_per_kolom["Kolom".$a2])){

                $total_per_kolom["Kolom".$a2]+=$text2->rating;
            
            }else{
                $total_per_kolom["Kolom".$a2]=0;
                $total_per_kolom["Kolom".$a2]+=$text2->rating;
            
            }  
         }
        }
        // dd($total_per_kolom);
        // $normalisasi=array();
        // $total_after_normalisasi=array();
        // foreach($index as $a => $text){
        //    foreach($simpan["kriteria-".$a] as $a2 => $text2 ){
        //        // dd($text2);
        //        $normalisasi["kriteria-".$a][$a2]=$text2/$total_per_kolom["Kolom".$a2];
        //        if(isset($total_after_normalisasi["kriteria-".$a2])){

        //        $total_after_normalisasi["kriteria-".$a2]+=$normalisasi["kriteria-".$a][$a2];
            
        //     }else{
        //        $total_after_normalisasi["kriteria-".$a2]=0;
        //        $total_after_normalisasi["kriteria-".$a2]+=$normalisasi["kriteria-".$a][$a2];
            
        //     }  
        //    }
        // }
        // dd($total_after_normalisasi);
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
        // dd($simpan);
        // dd($total_per_kolom);
        $ri=array();
        $ri=array(
            array(1,0.00),
            array(2,0.00),
            array(3,0.58),
            array(4,0.90),
            array(5,1.12),
            array(6,1.24),
            array(7,1.32),
            array(8,1.41),
            array(9,1.45),
            array(10,1.49),
            array(11,1.51),
            array(12,1.48),
            array(13,1.56),
            array(14,1.57),
            array(15,1.59),
        );
        //Mencari Eigen Vektor
        $simpan_normalisasi=array();
        $total_per_kolom_normalisasi=array();
        foreach($index as $a => $data){
            foreach($simpan["kriteria-".$a] as $a2 => $data2){
                $simpan_normalisasi["kriteria-".$a][$a2]=$data2/$total_per_kolom["Kolom".$a2];
                if(isset($total_per_kolom_normalisasi["Kolom".$a2])){
                    $total_per_kolom_normalisasi["Kolom".$a2]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                }else{
                    $total_per_kolom_normalisasi["Kolom".$a2]=0;
                    $total_per_kolom_normalisasi["Kolom".$a2]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                } 
                
            }
        };
        // dd($total_per_kolom_normalisasi);
        // dump($simpan_normalisasi);
        // dump($simpan);
        // dd($ri[0][0]);

        $n=Kriteria::all()->count();
        
        return view('SuperAdmin.kriteria_perbandingan_index',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi'));
        
    }
    // public function normalisasi(){
    //     $index=Kriteria::all();
    //     $simpan=array();
    //     $total_per_kolom=array();
    //     foreach($index as $a => $text){
    //     $temp=KriteriaPerbandingan::where('kriteria_1',$text->id)->get();
    //      foreach($temp as $a2 => $text2){
    //         $simpan["kriteria-".$a][$a2]=$text2->rating;
    //         if(isset($total_per_kolom["Kolom".$a2])){

    //             $total_per_kolom["Kolom".$a2]+=$text2->rating;
            
    //         }else{
    //             $total_per_kolom["Kolom".$a2]=0;
    //             $total_per_kolom["Kolom".$a2]+=$text2->rating;
            
    //         }  
    //      }
    //     }
    // }

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
