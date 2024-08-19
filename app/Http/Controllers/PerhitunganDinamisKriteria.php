<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
use App\Models\DinamisBobotTerkecil;
use App\Models\DinamisKriteria;
use App\Models\DinamisKriteriaPerbandingan;
use App\Models\Kriteria;
use App\Models\KriteriaRating;
use App\Models\SepedaListrik;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerhitunganDinamisKriteria extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=User::find(Auth::id()); 
        $kriteria=Kriteria::all();
        $dinamis_kriteria=DinamisKriteria::where('user_id',$user->id)->where('status','dipilih')->get();
        $bobot_kriteria_terkecil=DinamisBobotTerkecil::where('user_id',$user->id)->first();
        $temp_urutan_kriteria_static=array();
        $urutan_kriteria_static=array();
        //Buat Kriteria Urutan Static
        foreach($kriteria as $index => $data){
            $temp_urutan_kriteria_static[]=$data->id;
        }
        $temp_array=array_diff($temp_urutan_kriteria_static,[$bobot_kriteria_terkecil->kriteria_id]);
        $urutan_kriteria_static[]=$bobot_kriteria_terkecil->kriteria_id;
        foreach($temp_array as $index => $data){
            $urutan_kriteria_static[]=$data;
        }
        $perbandingan_bobot=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('status',"dipilih")->get();
        //PENGELOLAHAN DATA
        $n=DinamisKriteria::where('user_id',$user->id)->where('status','dipilih')->count();
        $simpan=array();
        $total_per_kolom=array();
        foreach($dinamis_kriteria as $index => $data){
        $temp=DinamisKriteriaPerbandingan::where('kriteria_1',$data->kriteria_id)->where('user_id',$user->id)->get();
         foreach($temp as $index2 => $data2){
            $simpan["kriteria-".$index][$index2]=$data2->rating;
            if(isset($total_per_kolom["Kolom".$index2])){

                $total_per_kolom["Kolom".$index2]+=$data2->rating;
            
            }else{
                $total_per_kolom["Kolom".$index2]=0;
                $total_per_kolom["Kolom".$index2]+=$data2->rating;
            
            }  
         }
        }
        //clear
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
        //Mencari Eigen Vektor
        $simpan_normalisasi=array();
        $total_per_kolom_normalisasi=array();
        $total_per_row_normalisasi=array();
        $average_per_row_normalisasi=array();
        // dd($simpan);
        foreach($dinamis_kriteria as $a => $data){
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
        // dd($simpan);
        foreach($dinamis_kriteria as $a => $data){
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
        return view('Pembeli.dinamis_perhitungan',compact('user','dinamis_kriteria','bobot_kriteria_terkecil','perbandingan_bobot','kriteria','urutan_kriteria_static','simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi',
    'n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function perhitungan_dinamis(){
        $user=User::find(Auth::id()); 
        $kriteria=Kriteria::all();
        $dinamis_kriteria=DinamisKriteria::where('user_id',$user->id)->where('status','dipilih')->get();
        $bobot_kriteria_terkecil=DinamisBobotTerkecil::where('user_id',$user->id)->first();
        $temp_urutan_kriteria_static=array();
        $urutan_kriteria_static=array();
        //Buat Kriteria Urutan Static
        foreach($kriteria as $index => $data){
            $temp_urutan_kriteria_static[]=$data->id;
        }
        $temp_array=array_diff($temp_urutan_kriteria_static,[$bobot_kriteria_terkecil->kriteria_id]);
        $urutan_kriteria_static[]=$bobot_kriteria_terkecil->kriteria_id;
        foreach($temp_array as $index => $data){
            $urutan_kriteria_static[]=$data;
        }
        $perbandingan_bobot=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('status',"dipilih")->get();
        //PENGELOLAHAN DATA
        $n=DinamisKriteria::where('user_id',$user->id)->where('status','dipilih')->count();
        $simpan=array();
        $total_per_kolom=array();
        foreach($dinamis_kriteria as $index => $data){
        $temp=DinamisKriteriaPerbandingan::where('kriteria_1',$data->kriteria_id)->where('user_id',$user->id)->get();
         foreach($temp as $index2 => $data2){
            $simpan["kriteria-".$index][$index2]=$data2->rating;
            if(isset($total_per_kolom["Kolom".$index2])){

                $total_per_kolom["Kolom".$index2]+=$data2->rating;
            
            }else{
                $total_per_kolom["Kolom".$index2]=0;
                $total_per_kolom["Kolom".$index2]+=$data2->rating;
            
            }  
         }
        }
        //clear
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
        //Mencari Eigen Vektor
        $simpan_normalisasi=array();
        $total_per_kolom_normalisasi=array();
        $total_per_row_normalisasi=array();
        $average_per_row_normalisasi=array();
        foreach($dinamis_kriteria as $a => $data){
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
        foreach($dinamis_kriteria as $a => $data){
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
        //----------------------------------------------------------
        //DATA SEPEDA NORMALISASI
        $data_sepeda = SepedaListrik::all();
        $sepeda = AlternatifValue::all();
        //Tahap Pembagi dan X Y
        $tahap_2_pembagi=array();
        $sepeda_normalisasi=array();
        //===================================================================
        //NORMALISASI DATA MOTOR SEPEDA 
        foreach($data_sepeda as $a => $data){
            $sepeda_normalisasi[$a]["id"]=$data->id;
            foreach($dinamis_kriteria as $a2 =>$data2){
                $data3=AlternatifValue::where('kriteria_id',$data2->kriteria_id)->where('alternatif_id',$data->id)->first();
                if($data->tipe=="sepeda listrik"){
                    $data4=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->kriteria_id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->kriteria_id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->kriteria_id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->kriteria_id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->kriteria_id)->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }
                    }else{
                        $nilai=$data4->value;
                    }
                    $tipe="sepeda listrik";
                }else{
                    $data4=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->kriteria_id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->kriteria_id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->kriteria_id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->kriteria_id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->kriteria_id)->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }
                    }else{
                        $nilai=$data4->value;
                    }
                    $tipe="sepeda motor listrik";
                }
                $sepeda_normalisasi[$a]["tipe"]=$tipe;
                $sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria]=$nilai;
            }
        }
        //=====================================================================
        //Tahap Cari R/X
        $sepeda_terbobot_x=array();
        $total_terbobot_x=array();
        foreach($data_sepeda as $a => $data){
            foreach($dinamis_kriteria as $a2 =>$data2){
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    $sepeda_terbobot_x["sepeda listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria]*$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria];
                }else{
                    $sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria]*$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria];
                }
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    if(isset($total_terbobot_x["sepeda listrik"][$a2])){
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->kriteria->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda listrik"][$a2]=0;
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->kriteria->nama_kriteria];

                    }
                }else{
                    if(isset($total_terbobot_x["sepeda motor listrik"][$a2])){
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda motor listrik"][$a2]=0;
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria];

                    }
                }
            }
        }
        //Tahap Cari R/X 2
        $sepeda_terbobot_x_2=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($dinamis_kriteria as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria]/sqrt($total_terbobot_x["sepeda listrik"][$a2]);
                }
            }else{
                foreach($dinamis_kriteria as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_normalisasi[$a][$data2->kriteria->nama_kriteria]/sqrt($total_terbobot_x["sepeda motor listrik"][$a2]);
                }
            }
        }
        //=====================================================================
        //Tahap Cari R/Y
        $sepeda_terbobot_y=array(array());
        $cari_Max_Min_Y=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($dinamis_kriteria as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->kriteria->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda listrik"][$data2->kriteria->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda listrik"][$a][$data2->kriteria->nama_kriteria];
                }
            }else{
                foreach($dinamis_kriteria as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria]=$sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda motor listrik"][$data2->kriteria->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->kriteria->nama_kriteria];
                }
            }
        }
        //=====================================================================
        // CARI A+ dan A-
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();

        foreach($dinamis_kriteria as $angka => $data ){
            if($data->kriteria->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->kriteria->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->kriteria->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->kriteria->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->kriteria->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->kriteria->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->kriteria->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->kriteria->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->kriteria->nama_kriteria]);
                
            }
            if($data->kriteria->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->kriteria->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->kriteria->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->kriteria->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->kriteria->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->kriteria->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->kriteria->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->kriteria->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->kriteria->nama_kriteria]);
            }

        }
        //=====================================================================
        //Jarak Antara Nilai Terbobot D+ and D-
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        // dd($sepeda_terbobot_y);
        foreach($data_sepeda as $angka => $data){
            foreach($dinamis_kriteria as $angka2 => $data2){
                if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                    if(isset($nilai_D_positif["sepeda listrik"][$angka])){
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->kriteria->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda listrik"][$angka]=0;
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->kriteria->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda listrik"][$angka])){
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->kriteria->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->kriteria->nama_kriteria],2);
                    }
                }else{
                    if(isset($nilai_D_positif["sepeda motor listrik"][$angka])){
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->kriteria->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->kriteria->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda motor listrik"][$angka])){
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->kriteria->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->kriteria->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->kriteria->nama_kriteria],2);
                    }
                }
            }
            if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                $nilai_D_positif["sepeda listrik"][$angka]=sqrt($nilai_D_positif["sepeda listrik"][$angka]);
                $nilai_D_negatif["sepeda listrik"][$angka]=sqrt($nilai_D_negatif["sepeda listrik"][$angka]);
            }else{
                $nilai_D_positif["sepeda motor listrik"][$angka]=sqrt($nilai_D_positif["sepeda motor listrik"][$angka]);
                $nilai_D_negatif["sepeda motor listrik"][$angka]=sqrt($nilai_D_negatif["sepeda motor listrik"][$angka]);
            }

        }
        // dd($nilai_D_positif);
        //=====================================================================
        ////RANKING OR NILAI PREFERENSI
        $nilai_preferensi=array();
        foreach($data_sepeda as $angka => $data){
            if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                $nilai_preferensi["sepeda listrik"][$angka]["Result"]=$nilai_D_negatif["sepeda listrik"][$angka]/($nilai_D_negatif["sepeda listrik"][$angka]+$nilai_D_positif["sepeda listrik"][$angka]);
                $nilai_preferensi["sepeda listrik"][$angka]["id"]=$data->id;
            }else{
                $nilai_preferensi["sepeda motor listrik"][$angka]["Result"]=$nilai_D_negatif["sepeda motor listrik"][$angka]/($nilai_D_negatif["sepeda motor listrik"][$angka]+$nilai_D_positif["sepeda motor listrik"][$angka]);
                $nilai_preferensi["sepeda motor listrik"][$angka]["id"]=$data->id;
            }

        }
        $descending_sepeda_listrik=$nilai_preferensi["sepeda listrik"];
        $descending_sepeda_motor=$nilai_preferensi["sepeda motor listrik"];
        // dd($nilai_preferensi);
        rsort($descending_sepeda_listrik);
        rsort($descending_sepeda_motor);
        $descending_nilai["sepeda motor listrik"] = collect($nilai_preferensi)->sortBy("Result")->values()->all();
        // dd($descending_sepeda_motor);
        // dd($sepeda_normalisasi);
        foreach($data_sepeda as $angka => $data){
            // dump($angka);
                if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                    foreach($descending_sepeda_listrik as $angka2 => $data2){
                        if($nilai_preferensi["sepeda listrik"][$angka]["id"]==$data2["id"]){
                            $nilai_preferensi["sepeda listrik"][$angka]["Rank"]=$angka2+1;
                        }
                    }
                }else{
                    foreach($descending_sepeda_motor as $angka2 => $data2){
                        if($nilai_preferensi["sepeda motor listrik"][$angka]["id"]==$data2["id"]){
                            $nilai_preferensi["sepeda motor listrik"][$angka]["Rank"]=$angka2+1;
                        }
                    }
                }
        }
        //=====================================================================
        return view('Pembeli.dinamis_perhitungan_motor_finale',compact('dinamis_kriteria','simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi','sepeda_normalisasi','sepeda_terbobot_x','total_terbobot_x','n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten','data_sepeda','sepeda',
    'tahap_2_pembagi','sepeda_terbobot_x','sepeda_terbobot_x_2','sepeda_terbobot_y','tahap_3_Solusi_Ideal_Positif','tahap_3_Solusi_Ideal_Negatif','nilai_D_negatif','nilai_D_positif','nilai_preferensi'));
        
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user=User::find(Auth::id());
        $bobot_kriteria_terkecil=DinamisBobotTerkecil::where('user_id',$user->id)->first();
        $kriteria=Kriteria::all();
        $kriteria2=DinamisKriteria::where('user_id',$user->id)->get();
        $bobot_kriteria_terkecil->kriteria_id=$request->setup_kriteria;
        $bobot_kriteria_terkecil->save();
        //Delete Perbandingan
        $perbandingan_kriteria=DinamisKriteriaPerbandingan::where('user_id',$user->id)->get();
        foreach($perbandingan_kriteria as $index => $data){
            $data->delete();
        }
        //Create Ulang
        $kriteria=Kriteria::all();
        // dd(Kriteria::count()-1);

        $temp_urutan_kriteria_static=array();
        $urutan_kriteria_static=array();
        //Buat Kriteria Urutan Static
        foreach($kriteria as $index => $data){
            $temp_urutan_kriteria_static[]=$data->id;
        }
        $temp_array=array_diff($temp_urutan_kriteria_static,[$bobot_kriteria_terkecil->kriteria_id]);
        $urutan_kriteria_static[]=$bobot_kriteria_terkecil->kriteria_id;
        foreach($temp_array as $index => $data){
            $urutan_kriteria_static[]=$data;
        }
        //didapatkan array static dengan urutan bobot kriteria terkecil
        foreach($urutan_kriteria_static as $index => $data){
            foreach($urutan_kriteria_static as $index2 => $data2){
                $kriteria_perbandingan=new DinamisKriteriaPerbandingan();
                $kriteria_perbandingan->user_id=$user->id;
                $kriteria_perbandingan->kriteria_1=$data;
                $kriteria_perbandingan->kriteria_2=$data2;
                if($data==$data2){
                    $kriteria_perbandingan->rating=1;
                }
                $kriteria_perbandingan->save();
            }
        }
        for($x=0; $x<2; $x++){
            $kriteria=Kriteria::all();
            $kriteria2=DinamisKriteria::where('user_id',$user->id)->get();
            foreach($kriteria as $index => $data){
                $data_perubahan=DinamisKriteria::where('user_id',$user->id)->where('kriteria_id',$data->id)->first();
                if($data_perubahan->status=="tidak dipilih"){
                    foreach($kriteria2 as $index2 => $data2){
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('kriteria_1',$data->id)->where('kriteria_2',$data2->kriteria_id)->first();
                        $kriteria_perbandingan->status="tidak dipilih";
                        $kriteria_perbandingan->save();
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('kriteria_1',$data2->kriteria_id)->where('kriteria_2',$data->id)->first();
                        $kriteria_perbandingan->status="tidak dipilih";
                        $kriteria_perbandingan->save();
                    }
                }else{
                    foreach($kriteria2 as $index2 => $data2){
                        $kriteria_perbandingan=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('kriteria_1',$data->id)->where('kriteria_2',$data2->kriteria_id)->first();
                        $kriteria_perbandingan2=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('kriteria_1',$data2->kriteria_id)->where('kriteria_2',$data->id)->first();
                        if($data2->status== "dipilih" AND $data_perubahan->status=="dipilih"){
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
        return redirect()->route('dinamis-bobot.index')->with('success','Data Berhasil Diubah');

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
        $table = $request->input('table'); 
        $user=User::find(Auth::id()); 
        $kriteria=Kriteria::all();
        $dinamis_kriteria=DinamisKriteria::where('user_id',$user->id)->where('status','dipilih')->get();
        $bobot_kriteria_terkecil=DinamisBobotTerkecil::where('user_id',$user->id)->first();
        $temp_urutan_kriteria_static=array();
        $urutan_kriteria_static=array();
        //Buat Kriteria Urutan Static
        foreach($kriteria as $index => $data){
            $temp_urutan_kriteria_static[]=$data->id;
        }
        $temp_array=array_diff($temp_urutan_kriteria_static,[$bobot_kriteria_terkecil->kriteria_id]);
        $urutan_kriteria_static[]=$bobot_kriteria_terkecil->kriteria_id;
        foreach($temp_array as $index => $data){
            $urutan_kriteria_static[]=$data;
        }
        $perbandingan_bobot=DinamisKriteriaPerbandingan::where('user_id',$user->id)->where('status',"dipilih")->get();
        // dd($urutan_kriteria_static);
        foreach($urutan_kriteria_static as $index => $data){
            foreach($perbandingan_bobot->where('kriteria_1',$data) as $index2 => $data2){
                $data2->rating=$table[$data][$data2->kriteria_2];
                $data2->save();
            }
        }
        return redirect()->route('dinamis-bobot.index')->with('success','Berhasil diubah');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
