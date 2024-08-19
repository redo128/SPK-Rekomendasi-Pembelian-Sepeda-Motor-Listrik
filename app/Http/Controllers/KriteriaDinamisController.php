<?php

namespace App\Http\Controllers;

use App\Models\DinamisBobotTerkecil;
use App\Models\DinamisKriteria;
use App\Models\DinamisKriteriaPerbandingan;
use App\Models\Kriteria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KriteriaDinamisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriteria=Kriteria::all();
        $user=User::find(Auth::id());
        $dinamis_pembeli=DinamisKriteria::where('user_id',$user->id)->get();
        // dd($dinamis_pembeli->isEmpty());
        if($dinamis_pembeli->isEmpty()){
            $status="kosong";
        }else{
            $status="ada";
        }
        return view('Pembeli.dinamis_kriteria',compact('status','kriteria','dinamis_pembeli','user'));
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
        $kriteria=Kriteria::all();
        $user=User::find(Auth::id());
        foreach($kriteria as $id => $data){
            $buat_data=new DinamisKriteria();
            $buat_data->user_id=$user->id;
            $buat_data->kriteria_id=$data->id;
            if($data->id==1){
                $data_bobot_kecil=new DinamisBobotTerkecil();
                $data_bobot_kecil->user_id=$user->id;
                $data_bobot_kecil->kriteria_id=$data->id;
                $data_bobot_kecil->save();
            }
            $buat_data->save();
            foreach($kriteria as $id2 => $data2){
                $kriteria_perbandingan=new DinamisKriteriaPerbandingan();
                $kriteria_perbandingan->user_id=$user->id;
                $kriteria_perbandingan->kriteria_1=$data->id;
                $kriteria_perbandingan->kriteria_2=$data2->id;
                if($data->id==$data2->id){
                    $kriteria_perbandingan->rating=1;
                }
                $kriteria_perbandingan->save();
            }
        }
        return redirect()->route('dinamis-kriteria.index')->with('success','berhasil dibuat');
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
        for($x=0; $x<2; $x++){
            $dinamis_kriteria = $request->input('dinamis_kriteria'); 
            // dd($dinamis_kriteria);
            $kriteria=Kriteria::all();
            $kriteria2=DinamisKriteria::where('user_id',$id)->get();
            foreach($kriteria as $index => $data){
                $user=DinamisKriteria::where('user_id',$id)->where('kriteria_id',$data->id)->first();
                $user->status=$dinamis_kriteria[$data->nama_kriteria];
                $user->save();
                if($user->status=="tidak dipilih"){
                    foreach($kriteria2 as $index2 => $data2){
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$id)->where('kriteria_1',$data->id)->where('kriteria_2',$data2->kriteria_id)->first();
                        $kriteria_perbandingan->status="tidak dipilih";
                        $kriteria_perbandingan->save();
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$id)->where('kriteria_1',$data2->kriteria_id)->where('kriteria_2',$data->id)->first();
                        $kriteria_perbandingan->status="tidak dipilih";
                        $kriteria_perbandingan->save();
                    }
                }else{
                    foreach($kriteria2 as $index2 => $data2){
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$id)->where('kriteria_1',$data->id)->where('kriteria_2',$data2->kriteria_id)->first();
                        $kriteria_perbandingan2=DinamisKriteriaPerbandingan::where('user_id',$id)->where('kriteria_1',$data2->kriteria_id)->where('kriteria_2',$data->id)->first();
                        if($data2->status== "dipilih" AND $user->status=="dipilih"){
                            $kriteria_perbandingan->status="dipilih";
                            $kriteria_perbandingan2->status="dipilih";
                            $kriteria_perbandingan->save();
                            $kriteria_perbandingan2->save();
                        }else{
                            $kriteria_perbandingan->status="tidak dipilih";
                            $kriteria_perbandingan2->status="tidak dipilih";
                            $kriteria_perbandingan->save();
                            $kriteria_perbandingan2->save();
                        }
                    }
                }
            }
        }
        return redirect()->route('dinamis-kriteria.index')->with('success','Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
