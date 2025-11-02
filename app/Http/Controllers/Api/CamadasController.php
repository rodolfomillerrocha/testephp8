<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layer;
use Illuminate\Http\JsonResponse;

class CamadasController extends Controller
{
    /**
     * Retorna todas as camadas em formato GeoJSON
     */
    public function index(): JsonResponse
    {
        $camadas = Layer::all();
        
        $features = $camadas->map(function ($camada) {
            $geometry = is_string($camada->geometry) 
                ? json_decode($camada->geometry, true) 
                : $camada->geometry;

            return [
                'type' => 'Feature',
                'properties' => [
                    'id' => $camada->id,
                    'nome' => $camada->nome,
                ],
                'geometry' => $geometry,
            ];
        });

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features,
        ]);
    }

    /**
     * Retorna uma camada específica
     */
    public function show($id): JsonResponse
    {
        $camada = Layer::findOrFail($id);
        
        $geometry = is_string($camada->geometry) 
            ? json_decode($camada->geometry, true) 
            : $camada->geometry;

        return response()->json([
            'type' => 'Feature',
            'properties' => [
                'id' => $camada->id,
                'nome' => $camada->nome,
            ],
            'geometry' => $geometry,
        ]);
    }
}





