<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Kriteria;
use App\Models\KriteriaPerbandingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Kriteria::all();
        $columns = DB::getSchemaBuilder()->getColumnListing('kriteria');
        return view('Superadmin.kriteria_index',compact('index','columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Superadmin.kriteria_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kriteria=new Kriteria;
        $kriteria->nama_kriteria=$request->get('nama_kriteria');
        $kriteria->save();
        $getcountkriteria=Kriteria::all();
        $temp=Kriteria::latest('id')->first();
        foreach($getcountkriteria as $count){
            $perbandingan= new KriteriaPerbandingan;
            $perbandingan->kriteria_1=$temp->id;
            $perbandingan->kriteria_2=$count->id;
            $perbandingan->rating=1;
            $perbandingan->save();
        }
        $getcountkriteria->pop();
        foreach($getcountkriteria as $count){
            $perbandingan= new KriteriaPerbandingan;
            $perbandingan->kriteria_1=$count->id;
            $perbandingan->kriteria_2=$temp->id;
            $perbandingan->rating=1;
            $perbandingan->save();
        }
        return redirect()->route('kriteria.index');
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
        $data=Kriteria::find($id);
        return view('Superadmin.kriteria_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kriteria=Kriteria::find($id);
        $kriteria->nama_kriteria=$request->get('nama_kriteria');
        $kriteria->type=$request->get('type');
        $kriteria->save();
        return redirect()->route('kriteria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kriteria=Kriteria::find($id);
        $kriteria->delete();
        return redirect()->route('kriteria.index');
    }
}
