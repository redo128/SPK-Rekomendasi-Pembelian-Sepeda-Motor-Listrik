<?php

namespace App\Http\Controllers;

use App\Models\AlternatifValue;
use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\KriteriaRating;
use App\Models\SepedaListrik;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class SuperAdminController extends Controller
{
    function index(){
        $data_sepeda=SepedaListrik::count();
        $data_toko=Toko::count();
        $data_brand=Brand::count();
        $kriteria_all=Kriteria::all();
        $sepeda_lastest = SepedaListrik::latest()->take(5)->get();
        $sepeda_value=AlternatifValue::all();
        return view('Superadmin.beranda',compact('data_sepeda','data_toko','data_brand','kriteria_all','sepeda_lastest','sepeda_value'));
    }
    function penentuan_bobot(){
        // $namauser=Auth::user()->name;
        $index=KriteriaRating::orderBy('tipe','ASC')->get();
        return view('Superadmin.kriteria_rating',compact('index'));
    }
    function penentuan_bobot_create(){
        $kriteria=Kriteria::all();
        return view('Superadmin.kriteria_rating_create',compact('kriteria'));
    }
    function penentuan_bobot_store(Request $request){
        $data=new KriteriaRating;
        $data->kriteria_id=$request->kriteria_id;
        $data->tipe=$request->tipe;
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
    function sub_admin(){
        $user=User::all();
        return view('SuperAdmin.sub_admin_toko',compact('user'));
    }
    function sub_admin_edit(String $id){
        $data=User::find($id);
        $toko=Toko::all();
        return view('SuperAdmin.sub_admin_toko_edit',compact('data','toko'));
    }
    function sub_admin_edit_password(String $id){
        $data=User::find($id);
        return view('SuperAdmin.sub_admin_toko_edit_password',compact('data'));
    }
    function sub_admin_update_password(Request $request,String $id){
        $data=User::find($id);
        $data->password=Hash::make($request->password);
        $data->save();
        return redirect()->route('SuperAdmin.sub.admin')->with('success','Password Berhasil Di ubah');
    }
    function sub_admin_update(Request $request ,String $id){
        $data=User::find($id);
        $data->name=$request->name;
        $data->email=$request->email;
        $data->role=$request->role;
        $data->toko_id=$request->toko_id;
        $data->save();
        return redirect()->route('SuperAdmin.sub.admin')->with('success','Data Berhasil Di ubah');
    }
    function sub_admin_delete(String $id){
        $user=User::find($id);
        $user->delete();
        return redirect()->back()->with('success','berhasil dihapus');
    }
}
