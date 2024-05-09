<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KriteriaPerbandinganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PerhitunganSuperAdmin;
use App\Http\Controllers\SepedaPembeliController;
use App\Http\Controllers\SepedaPenjualController;
use App\Http\Controllers\SepedaSuperAdminController;
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
Route::get('/login-auth',[LoginController::class,'login_auth'])->name('login-masuk');
Route::middleware(['auth'])->group(function(){
    // Route::get('/uwu',[LoginController::class,'index'])->name('login');
    // Route::post('/uwu',[LoginController::class,'login'])->name('login.auth');
    Route::resource('toko', TokoController::class)->middleware('userAkses:superadmin');
    Route::resource('brand', BrandController::class)->middleware('userAkses:superadmin');
    Route::resource('sepeda_sa', SepedaSuperAdminController::class)->middleware('userAkses:superadmin');
    Route::resource('kriteria', KriteriaController::class)->middleware('userAkses:superadmin');
    Route::resource('kriteriaperbandingan', KriteriaPerbandinganController::class)->middleware('userAkses:superadmin');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/perhitungan',[PerhitunganSuperAdmin::class,'index'])->name('Sa.perhitungan')->middleware('userAkses:superadmin');
    Route::get('/superadmin',[SuperAdminController::class,'index'])->name('SuperAdmin.beranda')->middleware('userAkses:superadmin');
    Route::get('/superadmin/bobot',[SuperAdminController::class,'penentuan_bobot'])->name('SuperAdmin.bobot')->middleware('userAkses:superadmin');
    // Route::get('/superadmin/toko',[SuperAdminController::class,'toko_index'])->name('SuperAdmin.toko')->middleware('userAkses:superadmin');
    // Route::get('/superadmin/toko/create',[SuperAdminController::class,'toko_create'])->name('Toko.create')->middleware('userAkses:superadmin');
    // Route::POST('/superadmin/toko/store',[SuperAdminController::class,'toko_store'])->name('Toko.store')->middleware('userAkses:superadmin');
    // Route::get('/penjual',[PenjualController::class,'index'])->name('Penjual.beranda')->middleware('userAkses:penjual');
    // Route::get('/pembeli',[PembeliController::class,'index'])->name('Pembeli.beranda')->middleware('userAkses:pembeli');
    Route::resource('pembeli', Pembelicontroller::class)->middleware('userAkses:pembeli');
    Route::get('/list-antrian',[PembeliController::class,'list_antrian'])->name('list_antrian')->middleware('userAkses:pembeli');
    Route::get('/preferensi-kriteria',[PembeliController::class,'preferensi_kriteria'])->name('preferensi_kriteria')->middleware('userAkses:pembeli');
    Route::get('/perhitungan-pembeli/{id}',[PembeliController::class,'perhitungan'])->name('perhitungan_pembeli')->middleware('userAkses:pembeli');
    Route::post('/api/value-brand-dropdown', [PembeliController::class,'kriteria_brand']);
    Route::post('/api/value-kriteria-dropdown', [PembeliController::class,'kriteria_value']);
    Route::get('/preferensi/kriteria-value', [PembeliController::class,'preferensi_kriteria_view'])->name('preferensi.value');
    Route::post('/pembeli/sepeda/{data}', [PembeliController::class,'custom_store'])->name('pembeli.custom.store');
    Route::resource('sepeda_pembeli', SepedaPembeliController::class)->middleware('userAkses:pembeli');
    Route::resource('penjual', PenjualController::class)->middleware('userAkses:penjual');
    Route::resource('sepeda_penjual', SepedaPenjualController::class)->middleware('userAkses:penjual');
});
Route::get('/tw',function(){
    return view('Layouts.main');
});