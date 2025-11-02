<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapaController extends Controller
{
    /**
     * Exibe a página inicial com o mapa
     */
    public function index()
    {
        return view('mapa');
    }
}





