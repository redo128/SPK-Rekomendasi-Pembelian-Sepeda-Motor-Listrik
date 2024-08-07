<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $index = Toko::all();
        $columns = DB::getSchemaBuilder()->getColumnListing('toko');
        return view('SuperAdmin.toko_index',compact('index','columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('SuperAdmin.toko_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $toko=new Toko;
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('toko', 'public');
        }
        $toko->nama_toko=$request->get('nama_toko');
        $toko->alamat=$request->get('alamat_toko');
        $toko->image=$filePath;
        $toko->save();
        return redirect()->route('toko.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Toko::find($id);
        return view('SuperAdmin.toko_detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data=Toko::find($id);
        return view('SuperAdmin.toko_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filePath = $file->store('toko', 'public');
        }
        $toko=Toko::find($id);
        $toko->nama_toko=$request->get('nama_toko');
        $toko->alamat=$request->get('alamat_toko');
        $toko->image=$filePath;
        $toko->save();
        return redirect()->route('toko.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $toko=Toko::find($id);
        $toko->delete();
        return redirect()->route('toko.index');
    }
}
