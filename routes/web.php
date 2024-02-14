<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function (){
    Route::get('/', function () {
        return redirect('/login');
    });
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('login.auth');
});
Route::get('/home',function(){
    return redirect('/login');
});
Route::middleware(['auth'])->group(function(){
    // Route::get('/uwu',[LoginController::class,'index'])->name('login');
    // Route::post('/uwu',[LoginController::class,'login'])->name('login.auth');
    Route::resource('toko', TokoController::class)->middleware('userAkses:superadmin');
    Route::resource('brand', BrandController::class)->middleware('userAkses:superadmin');
    Route::resource('kriteria', KriteriaController::class)->middleware('userAkses:superadmin');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/superadmin',[SuperAdminController::class,'index'])->name('SuperAdmin.beranda')->middleware('userAkses:superadmin');
    Route::get('/superadmin/bobot',[SuperAdminController::class,'penentuan_bobot'])->name('SuperAdmin.bobot')->middleware('userAkses:superadmin');
    // Route::get('/superadmin/toko',[SuperAdminController::class,'toko_index'])->name('SuperAdmin.toko')->middleware('userAkses:superadmin');
    // Route::get('/superadmin/toko/create',[SuperAdminController::class,'toko_create'])->name('Toko.create')->middleware('userAkses:superadmin');
    // Route::POST('/superadmin/toko/store',[SuperAdminController::class,'toko_store'])->name('Toko.store')->middleware('userAkses:superadmin');
    Route::get('/penjual',[PenjualController::class,'index'])->name('Penjual.beranda')->middleware('userAkses:penjual');
    Route::get('/pembeli',[PembeliController::class,'index'])->name('Pembeli.beranda')->middleware('userAkses:pembeli');
});

Route::get('/tw',function(){
    return view('Layouts.main');
});