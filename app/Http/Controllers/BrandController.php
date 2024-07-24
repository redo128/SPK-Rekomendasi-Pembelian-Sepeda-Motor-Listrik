<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Brand::all();
        $columns = DB::getSchemaBuilder()->getColumnListing('brand');
        return view('SuperAdmin.brand_index',compact('index','columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.brand_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $brand=new Brand;
        $brand->nama_brand=$request->get('nama_brand');
        $brand->save();
        return redirect()->route('brand.index');
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
        $data=Brand::find($id);
        return view('SuperAdmin.brand_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validated = $request->validate([
        //     'nama_toko' => 'required|unique:Toko,nama_toko,'.$id,'|max:255',
        // ],[
        //     'nama_toko.unique'=>'This Brand Name Already Taken',
            
        // ]);
        $brand=Brand::find($id);
        $brand->nama_brand=$request->get('nama_brand');
        $brand->save();
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand=Brand::find($id);
        $brand->delete();
        return redirect()->route('brand.index');
    }
}
