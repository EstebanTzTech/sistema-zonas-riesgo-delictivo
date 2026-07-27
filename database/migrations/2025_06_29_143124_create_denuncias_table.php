<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciasTable extends Migration
{
    public function up(): void
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->integer('edad');
            $table->string('direccion');
            $table->string('correo');
            $table->string('celular');
            $table->string('ci');
            $table->string('foto_carnet_anverso');
            $table->string('foto_carnet_reverso');
            $table->string('foto_rostro');
            $table->date('fecha_delito');
            $table->string('descripcion');
            $table->string('categoria_delito');
            $table->text('detalle');
            $table->decimal('latitud', 10, 6);
            $table->decimal('longitud', 10, 6);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
}
