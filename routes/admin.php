<?php

use Azuriom\Plugin\PlayerFlash\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('can:player.admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('home');
    Route::post("/update", [AdminController::class, 'update'])->name("update");
});