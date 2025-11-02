<?php

use App\Http\Controllers\Api\CamadasController;
use Illuminate\Support\Facades\Route;

Route::get('/camadas', [CamadasController::class, 'index'])->name('api.camadas.index');
Route::get('/camadas/{id}', [CamadasController::class, 'show'])->name('api.camadas.show');





