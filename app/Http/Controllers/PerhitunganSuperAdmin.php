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
    public function index()
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
        // $columns = DB::getSchemaBuilder()->getColumnListing('sepeda_listrik');
        $sepeda = AlternatifValue::all();
        //Tahap Pembagi dan X Y
        $tahap_2_pembagi=array();
        $sepeda_normalisasi=array();
        //===================================================================
        //NORMALISASI DATA MOTOR SEPEDA 
        foreach($data_sepeda as $a => $data){
            $sepeda_normalisasi[$a]["id"]=$a;
            // dump($data->id);
            foreach($index as $a2 =>$data2){
                $data3=AlternatifValue::where('kriteria_id',$data2->id)->where('alternatif_id',$data->id)->first();
                $data4=KriteriaRating::where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>=' ,$data3->value)->first();
                $nilai=$data4->value;
                $sepeda_normalisasi[$a][$data2->nama_kriteria]=$nilai;
            }
        }
        // dd($sepeda_normalisasi);
        //index====all kriteria
        //=====================================================================
        //Tahap Cari R/X
        $sepeda_terbobot_x=array();
        $total_terbobot_x=array();
        foreach($data_sepeda as $a => $data){
            foreach($index as $a2 =>$data2){
                $sepeda_terbobot_x[$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]*$sepeda_normalisasi[$a][$data2->nama_kriteria];
                if(isset($total_terbobot_x[$a2])){
                    $total_terbobot_x[$a2]+=$sepeda_terbobot_x[$a][$data2->nama_kriteria];
                }else{
                    $total_terbobot_x[$a2]=0;
                    $total_terbobot_x[$a2]+=$sepeda_terbobot_x[$a][$data2->nama_kriteria];

                }
            }
        }
        //Tahap Cari R/X 2
        $sepeda_terbobot_x_2=array();
        foreach($data_sepeda as $a => $data){
            foreach($index as $a2 =>$data2){
                // dd($sepeda_normalisasi[$a]/sqrt($total_terbobot_x[$a2]));
                $sepeda_terbobot_x_2[$a][$data2->nama_kriteria]=$sepeda_normalisasi[$a][$data2->nama_kriteria]/sqrt($total_terbobot_x[$a2]);
            }
        }
        //=====================================================================
        //Tahap Cari R/Y
        $sepeda_terbobot_y=array();
        $cari_Max_Min_Y=array();
        foreach($sepeda_terbobot_x_2 as $a => $data){
            foreach($index as $a2 =>$data2){
                $sepeda_terbobot_y[$a][$data2->nama_kriteria]=$data[$data2->nama_kriteria]*$average_per_row_normalisasi["Row".$a2];
                $cari_Max_Min_Y[$data2->nama_kriteria][$a]=$sepeda_terbobot_y[$a][$data2->nama_kriteria];
            }
        }
        // dd($sepeda_terbobot_y);
        // dd($cari_Max_Min_Y);
        //=====================================================================
        // CARI A+ dan A-
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();

        foreach($index as $angka => $data ){
            if($data->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif[$data->nama_kriteria]=max($cari_Max_Min_Y[$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Positif[$data->nama_kriteria]=min($cari_Max_Min_Y[$data->nama_kriteria]);
            }
            if($data->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif[$data->nama_kriteria]=max($cari_Max_Min_Y[$data->nama_kriteria]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif[$data->nama_kriteria]=min($cari_Max_Min_Y[$data->nama_kriteria]);
            }

        }
        // dd($tahap_3_Solusi_Ideal_Negatif);
        //=====================================================================
        //Jarak Antara Nilai Terbobot D+ and D-
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        // dd($sepeda_terbobot_y)
        foreach($sepeda_terbobot_y as $angka => $data){
            foreach($index as $angka2 => $data2){
                if(isset($nilai_D_positif[$angka])){
                    $nilai_D_positif[$angka]+=($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif[$data2->nama_kriteria])*($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif[$data2->nama_kriteria]);
                }else{
                    $nilai_D_positif[$angka]=0;
                    $nilai_D_positif[$angka]+=($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif[$data2->nama_kriteria])*($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Positif[$data2->nama_kriteria]);
                }
                if(isset($nilai_D_negatif[$angka])){
                    $nilai_D_negatif[$angka]+=pow($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif[$data2->nama_kriteria],2);
                }else{
                    $nilai_D_negatif[$angka]=0;
                    $nilai_D_negatif[$angka]+=pow($data[$data2->nama_kriteria]-$tahap_3_Solusi_Ideal_Negatif[$data2->nama_kriteria],2);
                }
            }

            $nilai_D_positif[$angka]=sqrt($nilai_D_positif[$angka]);
            $nilai_D_negatif[$angka]=sqrt($nilai_D_negatif[$angka]);
        }
        // dd($nilai_D_negatif);
        //=====================================================================
        ////RANKING OR NILAI PREFERENSI
        $nilai_preferensi=array();
        foreach($data_sepeda as $angka => $data){
            $nilai_preferensi[$angka]["Result"]=$nilai_D_negatif[$angka]/($nilai_D_negatif[$angka]+$nilai_D_positif[$angka]);
            $nilai_preferensi[$angka]["id"]=$data->id;
        }
        $descending_nilai=$nilai_preferensi;
        // dd($nilai_preferensi);
        rsort($descending_nilai);
        // dd($descending_nilai);
        foreach($descending_nilai as $angka => $data){
            foreach($nilai_preferensi as $angka2 => $data2){
                if($nilai_preferensi[$angka2]["Result"]==$data["Result"]){
                    $nilai_preferensi[$angka2]["Rank"]=$angka+1;

                }
            }
            // dd($data);
        }
        // dd($nilai_preferensi);
        // dd($sepeda_terbobot_x_2);
        // dd($sepeda_terbobot_y);
        //=====================================================================
        return view('SuperAdmin.perhitungan',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi','sepeda_terbobot_x','total_terbobot_x','n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten','data_sepeda','sepeda',
    'tahap_2_pembagi','sepeda_terbobot_x','sepeda_terbobot_x_2','sepeda_terbobot_y','tahap_3_Solusi_Ideal_Positif','tahap_3_Solusi_Ideal_Negatif','nilai_D_negatif','nilai_D_positif','nilai_preferensi'));
        
    }
}
