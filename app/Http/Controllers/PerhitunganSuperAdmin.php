<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
use App\Models\Kriteria;
use App\Models\KriteriaPerbandingan;
use App\Models\KriteriaRating;
use App\Models\SepedaListrik;
use Illuminate\Http\Request;

class PerhitunganSuperAdmin extends Controller
{
    public function index_sepeda_listrik()
    {
        $temp_data_check=SepedaListrik::all();
        if($temp_data_check->isEmpty()){
            return redirect()->route('sepeda_sa.index')->with('success', 'Data Sepeda Belum Ada');   
        }
        $index=Kriteria::all();
        $n=Kriteria::all()->count();
        //Panggil Perbandingan antar kriteria table 1
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
        //Mencari Eigen Vektor Table 2
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
        $MatrixXEv=array();
        $nMax=0;
        //Table 3
        foreach($index as $a => $data){
            $MatrixXEv["Row".$a]=0;
            foreach($simpan["kriteria-".$a] as $a2 => $data2){
                $MatrixXEv["Row".$a]+=$data2*$average_per_row_normalisasi["Row".$a2];
            }
            $nMax+=$MatrixXEv["Row".$a]/$average_per_row_normalisasi["Row".$a];
        }
        $nMax=$nMax/$n;
        $CI_Konsisten=($nMax-$n)/($n-1);
        $RI_Konsisten=$ri[$n-1];
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
            foreach($index as $a2 =>$data2){
                $data3=AlternatifValue::where('kriteria_id',$data2->id)->where('alternatif_id',$data->id)->first();
                if($data->tipe=="sepeda listrik"){
                    $data4=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }
                    }else{
                        $nilai=$data4->value;
                    }
                    $tipe="sepeda listrik";
                }else{
                    $data4=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->first();
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
                $sepeda_normalisasi[$a][$data2->nama_kriteria]=$nilai;
            }
        }
        //=====================================================================
        //Tahap Cari R/X
        $sepeda_terbobot_x=array();
        $total_terbobot_x=array();
        foreach($data_sepeda as $a => $data){
            foreach($index as $a2 =>$data2){
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    $sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]*$sepeda_normalisasi[$a][$data2->nama_kriteria];
                }else{
                    $sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]*$sepeda_normalisasi[$a][$data2->nama_kriteria];
                }
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    if(isset($total_terbobot_x["sepeda listrik"][$a2])){
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda listrik"][$a2]=0;
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria];

                    }
                }else{
                    if(isset($total_terbobot_x["sepeda motor listrik"][$a2])){
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda motor listrik"][$a2]=0;
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria];

                    }
                }
            }
        }
        //Tahap Cari R/X 2
        $sepeda_terbobot_x_2=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]/sqrt($total_terbobot_x["sepeda listrik"][$a2]);
                }
            }else{
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]/sqrt($total_terbobot_x["sepeda motor listrik"][$a2]);
                }
            }
        }
        //=====================================================================
        //Tahap Cari R/Y
        $sepeda_terbobot_y=array(array());
        $cari_Max_Min_Y=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda listrik"][$data2->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda listrik"][$a][$data2->nama_kriteria];
                }
            }else{
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda motor listrik"][$data2->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->nama_kriteria];
                }
            }
        }
        //=====================================================================
        // CARI A+ dan A-
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();

        foreach($index as $angka => $data ){
            if($data->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                
            }
            if($data->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }

        }
        //=====================================================================
        //Jarak Antara Nilai Terbobot D+ and D-
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        // dd($sepeda_terbobot_y);
        foreach($data_sepeda as $angka => $data){
            foreach($index as $angka2 => $data2){
                if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                    if(isset($nilai_D_positif["sepeda listrik"][$angka])){
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda listrik"][$angka]=0;
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda listrik"][$angka])){
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->nama_kriteria],2);
                    }
                }else{
                    if(isset($nilai_D_positif["sepeda motor listrik"][$angka])){
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda motor listrik"][$angka])){
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->nama_kriteria],2);
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
        // dd($sepeda_terbobot_x_2);
        // dd($nilai_preferensi);
        // dd($sepeda_terbobot_y);
        // dd($sepeda_normalisasi);
        //=====================================================================
        return view('SuperAdmin.perhitungan_sepeda_listrik',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi','sepeda_normalisasi','sepeda_terbobot_x','total_terbobot_x','n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten','data_sepeda','sepeda',
    'tahap_2_pembagi','sepeda_terbobot_x','sepeda_terbobot_x_2','sepeda_terbobot_y','tahap_3_Solusi_Ideal_Positif','tahap_3_Solusi_Ideal_Negatif','nilai_D_negatif','nilai_D_positif','nilai_preferensi'));
        
    }
    public function index_sepeda_motor_listrik()
    {
        $temp_data_check=SepedaListrik::all();
        if($temp_data_check->isEmpty()){
            return redirect()->route('sepeda_sa.index')->with('success', 'Data Sepeda Belum Ada');   
        }
        $index=Kriteria::all();
        $n=Kriteria::all()->count();
        //Panggil Perbandingan antar kriteria table 1
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
        //Mencari Eigen Vektor Table 2
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
        $MatrixXEv=array();
        $nMax=0;
        //Table 3
        foreach($index as $a => $data){
            $MatrixXEv["Row".$a]=0;
            foreach($simpan["kriteria-".$a] as $a2 => $data2){
                $MatrixXEv["Row".$a]+=$data2*$average_per_row_normalisasi["Row".$a2];
            }
            $nMax+=$MatrixXEv["Row".$a]/$average_per_row_normalisasi["Row".$a];
        }
        $nMax=$nMax/$n;
        $CI_Konsisten=($nMax-$n)/($n-1);
        $RI_Konsisten=$ri[$n-1];
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
            foreach($index as $a2 =>$data2){
                $data3=AlternatifValue::where('kriteria_id',$data2->id)->where('alternatif_id',$data->id)->first();
                if($data->tipe=="sepeda listrik"){
                    $data4=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda listrik')->where('kriteria_id',$data2->id)->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }
                    }else{
                        $nilai=$data4->value;
                    }
                    $tipe="sepeda listrik";
                }else{
                    $data4=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                    if($data4==null){
                        $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->first();
                        if($data2->type == "benefit"){
                            if($data3->value < $tempdata->min_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->latest('value')->first();
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }
                        }else{
                            $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->latest('id')->first();
                            if($data3->value > $tempdata->max_rating){
                                $data4=$tempdata->value;
                                $nilai=$data4;
                            }else{
                                $tempdata=KriteriaRating::where('tipe','sepeda motor listrik')->where('kriteria_id',$data2->id)->first();
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
                $sepeda_normalisasi[$a][$data2->nama_kriteria]=$nilai;
            }
        }
        //=====================================================================
        //Tahap Cari R/X
        $sepeda_terbobot_x=array();
        $total_terbobot_x=array();
        foreach($data_sepeda as $a => $data){
            foreach($index as $a2 =>$data2){
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    $sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]*$sepeda_normalisasi[$a][$data2->nama_kriteria];
                }else{
                    $sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]*$sepeda_normalisasi[$a][$data2->nama_kriteria];
                }
                if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                    if(isset($total_terbobot_x["sepeda listrik"][$a2])){
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda listrik"][$a2]=0;
                        $total_terbobot_x["sepeda listrik"][$a2]+=$sepeda_terbobot_x["sepeda listrik"][$a][$data2->nama_kriteria];

                    }
                }else{
                    if(isset($total_terbobot_x["sepeda motor listrik"][$a2])){
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria];
                    }else{
                        $total_terbobot_x["sepeda motor listrik"][$a2]=0;
                        $total_terbobot_x["sepeda motor listrik"][$a2]+=$sepeda_terbobot_x["sepeda motor listrik"][$a][$data2->nama_kriteria];

                    }
                }
            }
        }
        //Tahap Cari R/X 2
        $sepeda_terbobot_x_2=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]/sqrt($total_terbobot_x["sepeda listrik"][$a2]);
                }
            }else{
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]/sqrt($total_terbobot_x["sepeda motor listrik"][$a2]);
                }
            }
        }
        //=====================================================================
        //Tahap Cari R/Y
        $sepeda_terbobot_y=array(array());
        $cari_Max_Min_Y=array(array());
        foreach($data_sepeda as $a => $data){
            if($sepeda_normalisasi[$a]["tipe"]=="sepeda listrik"){
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda listrik"][$a][$data2->nama_kriteria]=$sepeda_terbobot_x_2["sepeda listrik"][$a][$data2->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda listrik"][$data2->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda listrik"][$a][$data2->nama_kriteria];
                }
            }else{
                foreach($index as $a2 =>$data2){
                    $sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->nama_kriteria]=$sepeda_terbobot_x_2["sepeda motor listrik"][$a][$data2->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                    $cari_Max_Min_Y["sepeda motor listrik"][$data2->nama_kriteria][$a]=$sepeda_terbobot_y["sepeda motor listrik"][$a][$data2->nama_kriteria];
                }
            }
        }
        //=====================================================================
        // CARI A+ dan A-
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();
        foreach($index as $angka => $data ){
            if($data->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                
            }
            if($data->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->nama_kriteria]=max($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda listrik"][$data->nama_kriteria]);
                $tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data->nama_kriteria]=min($cari_Max_Min_Y["sepeda motor listrik"][$data->nama_kriteria]);
            }

        }
        //=====================================================================
        //Jarak Antara Nilai Terbobot D+ and D-
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        // dd($sepeda_terbobot_y);
        foreach($data_sepeda as $angka => $data){
            foreach($index as $angka2 => $data2){
                if($sepeda_normalisasi[$angka]["tipe"]=="sepeda listrik"){
                    if(isset($nilai_D_positif["sepeda listrik"][$angka])){
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda listrik"][$angka]=0;
                        $nilai_D_positif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda listrik"][$data2->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda listrik"][$angka])){
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda listrik"][$data2->nama_kriteria],2);
                    }
                }else{
                    if(isset($nilai_D_positif["sepeda motor listrik"][$angka])){
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_positif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_positif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }
                    if(isset($nilai_D_negatif["sepeda motor listrik"][$angka])){
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->nama_kriteria],2);
                    }else{
                        $nilai_D_negatif["sepeda motor listrik"][$angka]=0;
                        $nilai_D_negatif["sepeda motor listrik"][$angka]+=pow($sepeda_terbobot_y["sepeda motor listrik"][$angka][$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif["sepeda motor listrik"][$data2->nama_kriteria],2);
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
        return view('SuperAdmin.perhitungan_sepeda_motor_listrik',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi','sepeda_normalisasi','sepeda_terbobot_x','total_terbobot_x','n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten','data_sepeda','sepeda',
    'tahap_2_pembagi','sepeda_terbobot_x','sepeda_terbobot_x_2','sepeda_terbobot_y','tahap_3_Solusi_Ideal_Positif','tahap_3_Solusi_Ideal_Negatif','nilai_D_negatif','nilai_D_positif','nilai_preferensi'));
        
    }
}
