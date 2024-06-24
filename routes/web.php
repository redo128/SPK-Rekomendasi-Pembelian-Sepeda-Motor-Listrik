<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KriteriaPerbandinganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PerhitunganSuperAdmin;
use App\Http\Controllers\RegisterController;
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
    Route::get('/login',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('login.auth');
    Route::get('/register',[RegisterController::class,'index'])->name('register_account');
    Route::post('/register-store',[RegisterController::class,'store'])->name('register_account_store');
});
Route::get('/home',function(){
    return redirect('/login');
});
Route::get('/login-auth',[LoginController::class,'login_auth'])->name('login-masuk');
Route::middleware(['auth'])->group(function(){
    Route::get('dashboard',[DashboardController::class,'index_sa'])->name('Dashboard')->middleware('userAkses:superadmin');
    Route::resource('toko', TokoController::class)->middleware('userAkses:superadmin');
    Route::resource('brand', BrandController::class)->middleware('userAkses:superadmin');
    Route::resource('sepeda_sa', SepedaSuperAdminController::class)->middleware('userAkses:superadmin');
    Route::resource('kriteria', KriteriaController::class)->middleware('userAkses:superadmin');
    Route::resource('kriteriaperbandingan', KriteriaPerbandinganController::class)->middleware('userAkses:superadmin');
    Route::get('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/perhitungan-sepeda-listrik',[PerhitunganSuperAdmin::class,'index_sepeda_listrik'])->name('Sa.perhitungan.sepeda.listrik')->middleware('userAkses:superadmin');
    Route::get('/perhitungan-sepeda-motor-listrik',[PerhitunganSuperAdmin::class,'index_sepeda_motor_listrik'])->name('Sa.perhitungan.sepeda.motor.listrik')->middleware('userAkses:superadmin');
    Route::get('/superadmin',[SuperAdminController::class,'index'])->name('SuperAdmin.beranda')->middleware('userAkses:superadmin');
    Route::get('/superadmin/bobot',[SuperAdminController::class,'penentuan_bobot'])->name('SuperAdmin.bobot')->middleware('userAkses:superadmin');
    Route::get('/superadmin/bobot-create',[SuperAdminController::class,'penentuan_bobot_create'])->name('SuperAdmin.bobot_create')->middleware('userAkses:superadmin');
    Route::post('/superadmin/bobot-store',[SuperAdminController::class,'penentuan_bobot_store'])->name('SuperAdmin.bobot_store')->middleware('userAkses:superadmin');
    Route::get('/superadmin/bobot/{id}',[SuperAdminController::class,'penentuan_bobot_edit'])->name('SuperAdmin.bobot_edit')->middleware('userAkses:superadmin');
    Route::put('/superadmin/bobot/{id}',[SuperAdminController::class,'penentuan_bobot_update'])->name('SuperAdmin.bobot_update')->middleware('userAkses:superadmin');
    Route::delete('/superadmin/bobot/{id}',[SuperAdminController::class,'penentuan_bobot_delete'])->name('SuperAdmin.bobot_delete')->middleware('userAkses:superadmin');
    Route::resource('pembeli', Pembelicontroller::class)->middleware('userAkses:pembeli');
    Route::get('/list-antrian',[PembeliController::class,'list_antrian'])->name('list_antrian')->middleware('userAkses:pembeli');
    Route::delete('/list-antrian-delete/{id}',[PembeliController::class,'list_antrian_delete'])->name('list_antrian_delete')->middleware('userAkses:pembeli');
    Route::get('/preferensi-kriteria',[PembeliController::class,'preferensi_kriteria'])->name('preferensi_kriteria')->middleware('userAkses:pembeli');
    Route::get('/perhitungan-pembeli/{id}',[PembeliController::class,'perhitungan'])->name('perhitungan_pembeli')->middleware('userAkses:pembeli');
    Route::post('/api/value-brand-dropdown', [PembeliController::class,'kriteria_brand']);
    Route::post('/api/value-kriteria-dropdown', [PembeliController::class,'kriteria_value']);
    Route::get('/preferensi/kriteria-value', [PembeliController::class,'preferensi_kriteria_view'])->name('preferensi.value');
    Route::get('/perhitungan-preferensi/kriteria-value', [PembeliController::class,'perhitungan_preferensi_kriteria_view'])->name('perhitungan.preferensi.value');
    Route::post('/api/orderby-users', [PembeliController::class,'testorder']);
    Route::post('/pembeli/sepeda/{data}', [PembeliController::class,'custom_store'])->name('pembeli.custom.store');
    Route::resource('sepeda_pembeli', SepedaPembeliController::class)->middleware('userAkses:pembeli');
    Route::post('api/kriteria', [PembeliController::class, 'fetchkriteria']);
    Route::resource('penjual', PenjualController::class)->middleware('userAkses:penjual');
    Route::resource('sepeda_penjual', SepedaPenjualController::class)->middleware('userAkses:penjual');
    Route::get('/wishlist-pembeli',[PenjualController::class, 'wishlist_pembeli'])->name('penjual.wishlist.pebeli')->middleware('userAkses:penjual');
});
Route::get('/tw',function(){
    return view('Layouts.main');
});