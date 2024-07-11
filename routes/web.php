<?php

use App\Http\Controllers\ArsipDokumenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchArsipDokumenController;
use App\Http\Controllers\VSModelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/////////////////////////////////////////////////////////
////////////////// L I N T A S VSM //////////////////////
/////////////////////////////////////////////////////////

// LOGIN
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

// REGISTER
Route::get('/register', [HomeController::class, 'register'])->name('register');

// HOME
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// LOGOUT
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// SEARCH ARSIP DOKUMEN
Route::get('/searchdokumen', [SearchArsipDokumenController::class, 'view'])->name('view')->middleware('auth');
Route::get('vsmodel', [VSModelController::class, 'proses'])->name('proses')->middleware('auth');

// GANTI PASSWORD
Route::get('/gpass', [HomeController::class, 'gpass'])->name('gpass')->middleware('auth');
Route::POST('/update_gpass', [HomeController::class, 'update_gpass'])->name('update_gpass');

// ARSIP DOKUMEN
Route::get('/arsipdokumen', [ArsipDokumenController::class, 'view'])->name('view')->middleware('auth');
Route::POST('/saveDoc', [ArsipDokumenController::class, 'saveDoc'])->name('saveDoc')->middleware('auth');
Route::get('/viewDoc', [ArsipDokumenController::class, 'viewDoc'])->name('viewDoc')->middleware('auth');
Route::get('/arsipdokumen/search', [ArsipDokumenController::class, 'search'])->name('search')->middleware('auth');
Route::get('dataDoc', [ArsipDokumenController::class, 'dataDoc'])->name('dataDoc')->middleware('auth');