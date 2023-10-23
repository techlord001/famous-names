<?php

use App\Http\Controllers\FamousNamesController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/famous-names', [FamousNamesController::class, 'index'])->name('famous-names.index');
Route::get('/famous-names/{id}/edit', [FamousNamesController::class, 'edit'])->name('famous-names.edit');
Route::patch('/famous-names/{id}', [FamousNamesController::class, 'update'])->name('famous-names.update');
Route::delete('/famous-names/{id}', [FamousNamesController::class, 'delete']);
