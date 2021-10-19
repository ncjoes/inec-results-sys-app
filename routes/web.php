<?php
declare(strict_types=1);

use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ResultController::class, 'index'])->name('index');
Route::get('polling-unit-result/{unit}', [ResultController::class, 'showUnitResult'])->name('unit-result');
Route::get('lga-result/{lga}', [ResultController::class, 'showLgaResult'])->name('lga-result');
Route::get('new-result', [ResultController::class, 'showNewResultForm'])->name('new-result');
Route::post('new-result', [ResultController::class, 'create'])->name('add-task');
