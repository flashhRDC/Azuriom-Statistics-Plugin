<?php

use Azuriom\Plugin\PlayerFlash\Controllers\PlayerFlashHomeController;
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

Route::get('/', [PlayerFlashHomeController::class, 'index'])->name("home");
Route::get('/{lastName}', [PlayerFlashHomeController::class, 'show'])->name("profile");
