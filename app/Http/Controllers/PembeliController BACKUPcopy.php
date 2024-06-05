<?php

namespace App\Http\Controllers;

use App\Models\AlternatifSelectPembeli;
use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\KriteriaPerbandingan;
use App\Models\KriteriaRating;
use App\Models\SepedaListrik;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $namauser=Auth::user()->name;
        return view('Pembeli.beranda',compact('namauser'));
    }
    public function preferensi_kriteria()
    {
       $data=Kriteria::all();
       foreach($data as $index => $ril){
           $test[$index]=$ril->nama_kriteria;
       }
       $data_rating=KriteriaRating::all();
        return view('Pembeli.preferensi_kriteria',compact('data','data_rating'),['test'=>$test]);
    }
    public function kriteria_brand(Request $request)
    {
        $data =  Brand::all();
        return response()->json($data);
    }
    public function kriteria_value(Request $request)
    {
        $data = KriteriaRating::where("kriteria_id", $request->kriteria_id)->get(["id","min_rating", "max_rating","value"]);
        return response()->json($data);
    }
    public function preferensi_kriteria_view(Request $request){
    $data_preferensi=KriteriaRating::find($request->value_dropdown_id);
    $data_sepeda=AlternatifValue::where('kriteria_id',$data_preferensi->kriteria_id)
    ->where('value', '>=', $data_preferensi->min_rating)
    ->where('value', '<', $data_preferensi->max_rating)
    ->get();
    $temp_value_id=array();
    foreach($data_sepeda as $id => $ex){
        // dd($ex->value);
        if($ex->value >= $data_preferensi->min_ratin AND $ex->value < $data_preferensi->max_rating){
            $temp_value_id[$id] = $ex;
        }
    }
    $data_sepeda=SepedaListrik::all();
    $data_alternatif=AlternatifValue::all();
    $data_katalog=AlternatifSelectPembeli::all();
    $kriteria_all=Kriteria::all();
    // dd($temp_value_id);
    return view('Pembeli.preferensi_kriteria_pilihan',compact('data_sepeda','data_alternatif','data_katalog','temp_value_id','kriteria_all'));
    }

    //PREFERENSI KRITERIA

    public function perhitungan_preferensi_kriteria_view(Request $request){
        $kriteria_all=Kriteria::all();
        $filter=array();
        $kriteria = $request->input('kriteria'); 
        $data_seoeda=SepedaListrik::all();
        $sepeda_view=array();
        foreach($data_seoeda as $index => $data){
            foreach($kriteria as $index2 => $data2){
                if($data2 == null){
                    
                }
                else{
                    $sepeda_value=AlternatifValue::where("kriteria_id",$index2)->where("alternatif_id",$data->id)->first();
                    $kriteria_check=KriteriaRating::where("kriteria_id",$index2)->where("id",$data2)->first();
                    if($sepeda_value->value >= $kriteria_check->min_rating AND $sepeda_value->value < $kriteria_check->max_rating){
                        if(isset($sepeda_view[$index])){
                            // dd("asdas");
                            if($sepeda_view[$index]==99){
                                // dd("sadsa");
                                $sepeda_view[$index]==null;
                            }
                            else{
                                $sepeda_view[$index]=$data->id;
                            }
                        }
                        else{
                            $sepeda_view[$index]=0;
                            $sepeda_view[$index]+=$data->id;
                        }
                    }else{
                        $sepeda_view[$index]=99;
                        // dd($sepeda_view);
                    }
                }
                // dd($sepeda_view);
            }
            if($sepeda_view[$index]!=99){
                $data_sepeda_satu=SepedaListrik::find($sepeda_view[$index]);
                $filter[$index]["id"]=$data_sepeda_satu->id;
                foreach($kriteria_all as $angka => $data_index){
                    $value=AlternatifValue::where("kriteria_id",$data_index->id)->where('alternatif_id',$sepeda_view[$index])->first();
                    $filter[$index][$data_index->nama_kriteria]=$value->value;
                }
            }
        }
        $data_alternatif=AlternatifValue::all();
        $sepeda_all=SepedaListrik::all();
        $kriteria_all=Kriteria::all();
        if(!empty($filter)){
            if($request->order == "ASC"){
                $items = collect($filter)->sortBy($request->kriteria_order)->values()->all();
            }else if($request->order == "DESC"){
                $items = collect($filter)->sortByDesc($request->kriteria_order)->values()->all();
            }
        //PERHITUNGAN
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
        $data_sepeda = SepedaListrik::all();
        // dd($items); <<<<<<<<<<<< Data Sepeda by Filter
        // $columns = DB::getSchemaBuilder()->getColumnListing('sepeda_listrik');
        $sepeda = AlternatifValue::all();
        //Tahap Pembagi dan X Y
        $tahap_2_pembagi=array();
        $sepeda_normalisasi=array();
        //===================================================================
        //NORMALISASI DATA MOTOR SEPEDA 
        //index====all kriteria
        foreach($items as $a => $data){
            $sepeda_normalisasi[$a]["id"]=$data["id"];
            foreach($index as $a2 =>$data2){
                $data3=AlternatifValue::where('kriteria_id',$data2->id)->where('alternatif_id',$data["id"])->first();
                $data4=KriteriaRating::where('kriteria_id',$data2->id)->where('min_rating' ,'<=' ,$data3->value)->where('max_rating' ,'>' ,$data3->value)->first();
                $nilai=$data4->value;
                $sepeda_normalisasi[$a][$data2->nama_kriteria]=$nilai;
            }
        }
        // dd($sepeda_normalisasi);
        //=====================================================================
        //Tahap Cari R/X
        $sepeda_terbobot_x=array();
        $total_terbobot_x=array();
        foreach($items as $a => $data){
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
        foreach($items as $a => $data){
            foreach($index as $a2 =>$data2){
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
        foreach($items as $angka => $data){
            $nilai_preferensi[$angka]["Result"]=$nilai_D_negatif[$angka]/($nilai_D_negatif[$angka]+$nilai_D_positif[$angka]);
            $nilai_preferensi[$angka]["id"]=$data["id"];
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
        foreach($index as $a => $data){
            //Mencari Pembagi table 6
            foreach($items as $a2 => $data2){
                if(isset($tahap_2_pembagi["Kolom".$a])){
                    $tahap_2_pembagi["Kolom".$a]+=$data2[$data->nama_kriteria]*$data2[$data->nama_kriteria];
                }else{
                    $tahap_2_pembagi["Kolom".$a]=0;
                    $tahap_2_pembagi["Kolom".$a]+=$data2[$data->nama_kriteria]*$data2[$data->nama_kriteria];
                    
                }
            }
            $tahap_2_pembagi["Kolom".$a]=sqrt($tahap_2_pembagi["Kolom".$a]);
        }
        //^^^^^^^DONE^^^^^^^^^^
        //Tahap Cari R
        // dd($tahap_2_pembagi);
        $tahap_2_R=array();
        foreach($items as $angka => $data){
            // $tempsepeda=AlternatifValue::where('alternatif_id',$data->id)->get();
            foreach($index as $a2 => $data2){
                if(isset($tahap_2_R["Kolom".$angka][$a2])){
                    $tahap_2_R["Kolom".$angka][$a2]+=$data[$data2->nama_kriteria]/$tahap_2_pembagi["Kolom".$a2];
                }else{
                    $tahap_2_R["Kolom".$angka][$a2]=0;
                    $tahap_2_R["Kolom".$angka][$a2]+=$data[$data2->nama_kriteria]/$tahap_2_pembagi["Kolom".$a2];
                }
            }
        }
        //Tahap Cari Y
        // dd($tahap_2_R);
        $tahap_2_Y=array();
        $cari_Max_Min_Y=array();
        foreach($items as $angka => $data){
            foreach($tahap_2_R["Kolom".$angka] as $angka2 => $data2){
                // dd($average_per_row_normalisasi);
                $tahap_2_Y["Kolom".$angka][$angka2]=$average_per_row_normalisasi["Row".$angka2]*$data2;
                $cari_Max_Min_Y[$angka2][$angka]=$tahap_2_Y["Kolom".$angka][$angka2];
            }  
        }
        // dd($tahap_2_Y);
        // dd($tahap_3_Solusi_Ideal);
        //Solusi Ideal Positif
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();

        foreach($index as $angka => $data ){
            if($data->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif[$angka]=max($cari_Max_Min_Y[$angka]);
            }else{
                $tahap_3_Solusi_Ideal_Positif[$angka]=min($cari_Max_Min_Y[$angka]);
            }
            if($data->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif[$angka]=max($cari_Max_Min_Y[$angka]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif[$angka]=min($cari_Max_Min_Y[$angka]);
            }

        }
        //Jarak Antara Nilai Terbobot
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        foreach($items as $angka => $data){
            foreach($tahap_2_Y["Kolom".$angka] as $angka2 => $data2){
                if(isset($nilai_D_positif["Row".$angka])){
                    $nilai_D_positif["Row".$angka]+=($data2-$tahap_3_Solusi_Ideal_Positif[$angka2])*($data2-$tahap_3_Solusi_Ideal_Positif[$angka2]);
                }else{
                    $nilai_D_positif["Row".$angka]=0;
                    $nilai_D_positif["Row".$angka]+=($data2-$tahap_3_Solusi_Ideal_Positif[$angka2])*($data2-$tahap_3_Solusi_Ideal_Positif[$angka2]);
                }
                if(isset($nilai_D_negatif["Row".$angka])){
                    $nilai_D_negatif["Row".$angka]+=pow(($data2-$tahap_3_Solusi_Ideal_Negatif[$angka2]),2);
                }else{
                    $nilai_D_negatif["Row".$angka]=0;
                    $nilai_D_negatif["Row".$angka]+=pow(($data2-$tahap_3_Solusi_Ideal_Negatif[$angka2]),2);
                }
            }

            $nilai_D_positif["Row".$angka]=sqrt($nilai_D_positif["Row".$angka]);
            $nilai_D_negatif["Row".$angka]=sqrt($nilai_D_negatif["Row".$angka]);
        }
        // dd($nilai_D_negatif);
        $nilai_preferensi=array();
        // dd($items);
        foreach($items as $angka => $data){
            $nilai_preferensi[$angka]["Result"]=$nilai_D_negatif["Row".$angka]/($nilai_D_negatif["Row".$angka]+$nilai_D_positif["Row".$angka]);
            $nilai_preferensi[$angka]["id"]=$data["id"];
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
        // dd($descending_nilai);
        // dd($nilai_preferensi);
        // dd($items);
        $nilai="ada";
        return view('Pembeli.preferensi_kriteria_view',compact('kriteria_all','data_alternatif','sepeda_all','items','nilai_preferensi','nilai'),['sepeda_view' => $sepeda_view]);
    }else{
        $nilai="kosong";
        return view('Pembeli.preferensi_kriteria_view',compact('kriteria_all','data_alternatif','sepeda_all','nilai'),['sepeda_view' => $sepeda_view]);
    }
    }
    
    public function orderby(Request $request){
        $kriteria = $request->input('kriteria'); 
        $kriteria_all=Kriteria::all();
        $filter=[[]];
        // dd($kriteria);
        $data_seoeda=SepedaListrik::all();
        $sepeda_view=array();
        foreach($data_seoeda as $index => $data){
            // $sepeda_value=AlternatifValue::where("alternatif_id",$data->id)->get();
            foreach($kriteria as $index2 => $data2){
                if($data2 == null){
                    if(isset($sepeda_view[$index])){
                        if($sepeda_view[$index]==null){
                            $sepeda_view[$index]=$data->id;
                        }
                        else{
                            $sepeda_view[$index]=null;
                        }
                       
                    }
                    else{
                        $sepeda_view[$index]=0;
                        $sepeda_view[$index]+=$data->id;
                    }
                }
                else{
                    // dd("MASK ");
                    $sepeda_value=AlternatifValue::where("kriteria_id",$index2)->where("alternatif_id",$data->id)->first();
                    $kriteria_check=KriteriaRating::where("kriteria_id",$index2)->where("id",$data2)->first();
                    
                    // dd($sepeda_value);
                    // dd($kriteria_check);
                    if($sepeda_value->value >= $kriteria_check->min_rating AND $sepeda_value->value < $kriteria_check->max_rating){
                        // dd("MASK2");
                        if(isset($sepeda_view[$index])){
                            $sepeda_view[$index]=$data->id;
                        }
                        else{
                            $sepeda_view[$index]=0;
                            $sepeda_view[$index]+=$data->id;
                        }
                    }else{
                        $sepeda_view[$index]=null;
                    }
                }
            }
            if($sepeda_view[$index]!=null){
            $data_sepeda_satu=SepedaListrik::find($sepeda_view[$index]);
            $filter[$index]["id"]=$data_sepeda_satu->id;
            foreach($kriteria_all as $angka => $data_index){
                $value=AlternatifValue::where("kriteria_id",$data_index->id)->where('alternatif_id',$sepeda_view[$index])->first();
                $filter[$index][$data_index->nama_kriteria]=$value->value;
            }
            }
        }
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

    }

    public function store(Request $request)
    {
        // $data=new AlternatifSelectPembeli;
        // dd($request);
        // $data->alternatif_id=$request->get('id');
        // $data->user_id=Auth::user()->id;
        // $data->save();
        // return redirect()->route('Pembeli.index');
    }
    public function custom_store(string $id)
    {
        $data=new AlternatifSelectPembeli;
        $data->alternatif_id=$id;
        $data->user_id=Auth::user()->id;
        $data->save();
        return redirect()->route('sepeda_pembeli.index');
    }
    public function list_antrian()
    {
        $spek=Kriteria::all();
        $data_sepeda=AlternatifSelectPembeli::where('user_id',Auth::user()->id)->get();
        // dd(AlternatifSelectPembeli::where('user_id',Auth::user()->id)->get());
        $data_sepeda_all=SepedaListrik::all();
        $data_alternatif=AlternatifValue::all();
        return view('Pembeli.list_antrian',compact('spek','data_sepeda','data_alternatif','data_sepeda_all'));
    }



    public function perhitungan(string $id)
    {
        $data_sepeda_all=SepedaListrik::all();
        $temp_data_check=SepedaListrik::all();
        if(Auth::user()->id != $id){
            return redirect()->route('sepeda_pembeli.index')->with('success', 'User ini tidak bisa akses');
        }
        if($temp_data_check->isEmpty()){
            return redirect()->route('perhitungan_pembeli')->with('success', 'Data Sepeda Belum Ada');   
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
        $data_sepeda = AlternatifSelectPembeli::where("user_id",Auth::user()->id)->get();
        
        // $columns = DB::getSchemaBuilder()->getColumnListing('sepeda_listrik');
        $sepeda = AlternatifValue::all();
        //Tahap Pembagi dan X Y
        $tahap_2_pembagi=array();

        foreach($index as $a => $data){
            //Mencari Pembagi table 6
            foreach($sepeda->where("kriteria_id",$data->id) as $a2 => $data2){
                if(isset($tahap_2_pembagi["Kolom".$a])){
                    $tahap_2_pembagi["Kolom".$a]+=$data2->value*$data2->value;
                }else{
                    $tahap_2_pembagi["Kolom".$a]=0;
                    $tahap_2_pembagi["Kolom".$a]+=$data2->value*$data2->value;
                }
            }
            $tahap_2_pembagi["Kolom".$a]=sqrt($tahap_2_pembagi["Kolom".$a]);
        }
        // dd($tahap_2_pembagi);
        //Tahap Cari R
        // dd($tahap_2_pembagi);
        $tahap_2_R=array();
        foreach($data_sepeda as $angka => $data){
            $tempsepeda=AlternatifValue::where('alternatif_id',$data->alternatif_id)->get();
            foreach($tempsepeda as $a2 => $data2){
                if(isset($tahap_2_R["Kolom".$angka][$a2])){
                    $tahap_2_R["Kolom".$angka][$a2]+=$data2->value/$tahap_2_pembagi["Kolom".$a2];
                    
                }else{
                    $tahap_2_R["Kolom".$angka][$a2]=0;
                    $tahap_2_R["Kolom".$angka][$a2]+=$data2->value/$tahap_2_pembagi["Kolom".$a2];
                }
            }
        }
        // dd($tahap_2_R);
        //Tahap Cari Y
        $tahap_2_Y=array();
        $cari_Max_Min_Y=array();
        foreach($data_sepeda as $angka => $data){
            
            foreach($tahap_2_R["Kolom".$angka] as $angka2 => $data2){
                // dd($average_per_row_normalisasi);
                $tahap_2_Y["Kolom".$angka][$angka2]=$average_per_row_normalisasi["Row".$angka2]*$data2;
                $cari_Max_Min_Y[$angka2][$angka]=$tahap_2_Y["Kolom".$angka][$angka2];
            }  
        }
        // dd($tahap_3_Solusi_Ideal);
        //Solusi Ideal Positif
        $tahap_3_Solusi_Ideal_Positif=array();
        $tahap_3_Solusi_Ideal_Negatif=array();

        foreach($index as $angka => $data ){
            if($data->type == "benefit"){
                $tahap_3_Solusi_Ideal_Positif[$angka]=max($cari_Max_Min_Y[$angka]);
            }else{
                $tahap_3_Solusi_Ideal_Positif[$angka]=min($cari_Max_Min_Y[$angka]);
            }
            if($data->type == "cost"){
                $tahap_3_Solusi_Ideal_Negatif[$angka]=max($cari_Max_Min_Y[$angka]);
            }else{
                $tahap_3_Solusi_Ideal_Negatif[$angka]=min($cari_Max_Min_Y[$angka]);
            }

        }
        //Jarak Antara Nilai Terbobot
        $nilai_D_positif=array();
        $nilai_D_negatif=array();
        foreach($data_sepeda as $angka => $data){
            foreach($tahap_2_Y["Kolom".$angka] as $angka2 => $data2){
                if(isset($nilai_D_positif["Row".$angka])){
                    $nilai_D_positif["Row".$angka]+=($data2-$tahap_3_Solusi_Ideal_Positif[$angka2])*($data2-$tahap_3_Solusi_Ideal_Positif[$angka2]);
                }else{
                    $nilai_D_positif["Row".$angka]=0;
                    $nilai_D_positif["Row".$angka]+=($data2-$tahap_3_Solusi_Ideal_Positif[$angka2])*($data2-$tahap_3_Solusi_Ideal_Positif[$angka2]);
                }
                if(isset($nilai_D_negatif["Row".$angka])){
                    $nilai_D_negatif["Row".$angka]+=pow(($data2-$tahap_3_Solusi_Ideal_Negatif[$angka2]),2);
                }else{
                    $nilai_D_negatif["Row".$angka]=0;
                    $nilai_D_negatif["Row".$angka]+=pow(($data2-$tahap_3_Solusi_Ideal_Negatif[$angka2]),2);
                }
            }

            $nilai_D_positif["Row".$angka]=sqrt($nilai_D_positif["Row".$angka]);
            $nilai_D_negatif["Row".$angka]=sqrt($nilai_D_negatif["Row".$angka]);
        }
        $nilai_preferensi=array();
        foreach($data_sepeda as $angka => $data){
            $nilai_preferensi[$angka]["Result"]=$nilai_D_negatif["Row".$angka]/($nilai_D_negatif["Row".$angka]+$nilai_D_positif["Row".$angka]);
            $nilai_preferensi[$angka]["id"]=$angka+1;
        }
        $descending_nilai=$nilai_preferensi;
        // dd($nilai_preferensi);
        rsort($descending_nilai);
        foreach($descending_nilai as $angka => $data){
            foreach($nilai_preferensi as $angka2 => $data2){
                if($nilai_preferensi[$angka2]["Result"]==$data["Result"]){
                    $nilai_preferensi[$angka2]["Rank"]=$angka+1;

                }
            }
            // dd($data);
        }
        // dd($nilai_preferensi);
        return view('Pembeli.perhitungan',compact('simpan','index','total_per_kolom','ri','total_per_kolom_normalisasi','simpan_normalisasi',
    'n','total_per_row_normalisasi','average_per_row_normalisasi','MatrixXEv','nMax','CI_Konsisten','RI_Konsisten','CR_Konsisten','data_sepeda','data_sepeda_all','sepeda',
    'tahap_2_pembagi','tahap_2_R','tahap_2_Y','tahap_3_Solusi_Ideal_Positif','tahap_3_Solusi_Ideal_Negatif','nilai_D_negatif','nilai_D_positif','nilai_preferensi'));
        
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
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
