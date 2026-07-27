<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('historial_delitos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('delito_id')->nullable();
        $table->unsignedBigInteger('usuario_id')->nullable();
        $table->string('accion'); // editar o eliminar
        $table->text('descripcion_cambio')->nullable();
        $table->timestamp('fecha_accion')->useCurrent();

        $table->foreign('delito_id')->references('id')->on('delitos')->onDelete('set null');
        $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
    });
}

};
