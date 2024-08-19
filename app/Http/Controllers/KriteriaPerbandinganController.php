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
        $n=Kriteria::all()->count();
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
        $ri=array();
        $ri=array(
            array(0.00),
            array(0.00),
            array(0.58),
            array(0.90),
            array(1.12),
            array(1.24),
            array(1.32),
            array(1.41),
            array(1.45),
            array(1.49),
            array(1.51),
            array(1.48),
            array(1.56),
            array(1.57),
            array(1.59),
        );
        // dd($ri[4]);
        //Mencari Eigen Vektor
        $simpan_normalisasi=array();
        $total_per_kolom_normalisasi=array();
        $total_per_row_normalisasi=array();
        $average_per_row_normalisasi=array();
        foreach($index as $a => $data){
            foreach($simpan["kriteria-".$a] as $a2 => $data2){
                $simpan_normalisasi["kriteria-".$a][$a2]=$data2/$total_per_kolom["Kolom".$a2];
                if(isset($total_per_kolom_normalisasi["Kolom".$a2])){
                    $total_per_kolom_normalisasi["Kolom".$a2]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                }else{
                    $total_per_kolom_normalisasi["Kolom".$a2]=0;
                    $total_per_kolom_normalisasi["Kolom".$a2]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                }
                if(isset($total_per_row_normalisasi["Row".$a])){
                    $total_per_row_normalisasi["Row".$a]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                }else{
                    $total_per_row_normalisasi["Row".$a]=0;
                    $total_per_row_normalisasi["Row".$a]+=$simpan_normalisasi["kriteria-".$a][$a2];
                
                }  
            }
            $average_per_row_normalisasi["Row".$a]=$total_per_row_normalisasi["Row".$a]/$n;
        };
        // Mencari Matriks X EV
        $MatrixXEv=array();
        $nMax=0;
        foreach($index as $a => $data){
            $MatrixXEv["Row".$a]=0;
            foreach($simpan["kriteria-".$a] as $a2 => $data2){
                $MatrixXEv["Row".$a]+=$data2*$average_per_row_normalisasi["Row".$a2];
            }
            $nMax+=$MatrixXEv["Row".$a]/$average_per_row_normalisasi["Row".$a];
        }
        $nMax=$nMax/$n;
        $CI_Konsisten=($nMax-$n)/($n-1);
        // dd($CI_Konsisten);
        $RI_Konsisten=$ri[$n-1];
        // dd($CI_Konsisten/$RI_Konsisten[0]);
        $CR_Konsisten=$CI_Konsisten/$RI_Konsisten[0];

        
        return view('Superadmin.kriteria_perbandingan_index',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi',
    'n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        return view('Superadmin.kriteria_perbandingan_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= new Kriteria() ;
        $data->nama_kriteria=$request->nama_kriteria;
        $data->save();
        return redirect()->route('kriteriaperbandingan.index')->with('success','Kriteria Berhasil DIbuat');
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
        $index=Kriteria::all();
        $dataperbandingan=KriteriaPerbandingan::all()->where("kriteria_1",$id);
        // dd($dataperbandingan);
        $find=Kriteria::find($id);
        return view('Superadmin.kriteria_perbandingan_edit',compact('index','dataperbandingan','find'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rating = $request->input('rating'); 
        $kriteria=Kriteria::all();
        foreach($kriteria as $loop){
            // dd($loop); << Nama Kriteria
            if(KriteriaPerbandingan::where("kriteria_1",$id)->where("kriteria_2",$loop->id)->exists()){
                $dataperbandingan=KriteriaPerbandingan::where("kriteria_1",$id)->where("kriteria_2",$loop->id)->first();
                // dd($dataperbandingan);
                $dataperbandingan->rating=$rating[$id][$dataperbandingan->id];
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
        return redirect()->route('kriteriaperbandingan.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
