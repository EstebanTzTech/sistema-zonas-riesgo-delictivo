<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('delitos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_zona');
            $table->string('nivel_riesgo');
            $table->decimal('radio', 8, 2);
            $table->string('fuente_informacion');
            $table->string('estado_delito');
            $table->string('tipo_delito');
            $table->datetime('fecha_hora');
            $table->text('descripcion')->nullable();
            $table->decimal('latitud_centro', 10, 7);
            $table->decimal('longitud_centro', 10, 7);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delitos');
    }
};
