<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layer extends Model
{
    use HasFactory;

    protected $table = 'layers';

    protected $fillable = [
        'nome',
        'geometry',
    ];

    protected $casts = [
        'geometry' => 'array',
    ];

    /**
     * Obtém a geometria em formato GeoJSON
     */
    public function obterGeoJson()
    {
        return $this->geometry;
    }

    /**
     * Define a geometria a partir de um GeoJSON
     */
    public function definirGeoJson($geojson)
    {
        $this->geometry = is_array($geojson) ? $geojson : json_decode($geojson, true);
        return $this;
    }
}





