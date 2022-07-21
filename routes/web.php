<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('index');
Route::post('/multimedia', [\App\Http\Controllers\ParticipationController::class, 'upload'])->name('multimedia');
Route::get('/{participation}/excel', [\App\Http\Controllers\ParticipationController::class, 'excel'])->name('excel');
Route::post('/upload-excel', [\App\Http\Controllers\ParticipationController::class, 'uploadExcel'])->name('uploadExcel');
require __DIR__.'/auth.php';
