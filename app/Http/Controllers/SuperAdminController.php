<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\KriteriaRating;
use App\Models\Toko;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SuperAdminController extends Controller
{
    function index(){
        return view('SuperAdmin.beranda');
    }
    function penentuan_bobot(){
        // $namauser=Auth::user()->name;
        $index=KriteriaRating::orderBy('kriteria_id','ASC')->get();
        return view('Superadmin.kriteria_rating',compact('index'));
    }
    function penentuan_bobot_create(){
        $kriteria=Kriteria::all();
        return view('Superadmin.kriteria_rating_create',compact('kriteria'));
    }
    function penentuan_bobot_store(Request $request){
        $data=new KriteriaRating;
        $data->kriteria_id=$request->kriteria_id;
        $data->min_rating=$request->min_rating;
        $data->max_rating=$request->max_rating;
        $data->value=$request->value;
        $data->save();
        return redirect()->route('SuperAdmin.bobot');
    }
    function penentuan_bobot_edit(String $id){
        $data=KriteriaRating::find($id);
        $kriteria=Kriteria::all();
        return view('Superadmin.kriteria_rating_edit',compact('data','kriteria'));
    }
    function penentuan_bobot_update(Request $request, String $id){
        $data=KriteriaRating::find($id);
        $data->kriteria_id=$request->kriteria_id;
        $data->min_rating=$request->min_rating;
        $data->max_rating=$request->max_rating;
        $data->value=$request->value;
        $data->save();
        return redirect()->route('SuperAdmin.bobot');
    }
    function penentuan_bobot_delete(String $id){
        $data=KriteriaRating::find($id);
        $data->delete();
        return redirect()->route('SuperAdmin.bobot');

    }
    public function toko_store(Request $request): RedirectResponse
    {
        $toko = $request->name;
 
        // Store the user...
 
        return redirect('/users');
    }
    function toko_edit(){

    }
    function toko_delete(){

    }
}
