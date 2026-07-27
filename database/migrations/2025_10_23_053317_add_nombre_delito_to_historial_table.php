<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Usamos Schema::table para modificar la tabla existente
        Schema::table('historial_delitos', function (Blueprint $table) {
            // Añadimos el campo tipo_delito_nombre para guardar el nombre antes de la eliminación
            $table->string('tipo_delito_nombre')->nullable()->after('accion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_delitos', function (Blueprint $table) {
            $table->dropColumn('tipo_delito_nombre');
        });
    }
};