<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Executa as migrações
     */
    public function up(): void
    {
        // Criar extensão PostGIS se não existir
        DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');

        Schema::create('layers', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->json('geometry'); // Armazenamento GeoJSON
            $table->timestamps();

            // Índice espacial para melhor performance
            $table->index(['nome']);
        });

        // Criar índice GIST para dados espaciais
        DB::statement('CREATE INDEX IF NOT EXISTS layers_geometry_idx ON layers USING GIST ((geometry::geometry))');
    }

    /**
     * Reverte as migrações
     */
    public function down(): void
    {
        Schema::dropIfExists('layers');
        DB::statement('DROP EXTENSION IF EXISTS postgis CASCADE');
    }
};





