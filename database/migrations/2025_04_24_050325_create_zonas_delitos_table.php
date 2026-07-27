<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('zonas_delitos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_zona');
            $table->string('nivel_riesgo');
            $table->float('latitud_centro', 10, 6);
            $table->float('longitud_centro', 10, 6);
            $table->float('radio');
            $table->string('tipo_delito');
            $table->text('descripcion');
            $table->timestamp('fecha_hora');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zonas_delitos');
    }
};
