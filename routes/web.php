<?php

use App\Http\Controllers\MapaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MapaController::class, 'index'])->name('mapa');





