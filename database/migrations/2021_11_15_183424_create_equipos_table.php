<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fua', 20)->unique();
            $table->foreignId('familia_id')->constrained('familias');
            $table->string('serie', 50);
            $table->string('modelo', 50);
            $table->string('year', 50);
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->enum('origen', 
            [
                'NACIONAL',
                'IMPORTADO',
            ]);
            $table->string('factura', 20);
            $table->string('pedimento', 50);
            $table->date('fecha_adquisicion');
            $table->bigInteger('horometro');
            $table->string('placas', 20);
            $table->enum('moneda', 
            [
                'MXN',
                'USD',
            ]);
            $table->decimal('cotizacion_usd', 8, 2);
            $table->decimal('valor_compra', 15, 2);
            $table->decimal('valor_traslado', 15, 2);
            $table->decimal('valor_importacion', 15, 2);
            $table->decimal('renta_hora', 15, 2);
            $table->decimal('renta_dia', 15, 2);
            $table->decimal('renta_semana', 15, 2);
            $table->decimal('renta_mes', 15, 2);
            $table->text('comentarios')->nullable();
            $table->enum('propietario', 
            [
                'DM',
                'G3',
            ]);
            $table->foreignId('clave_producto_id')->constrained('clave_productos');
            $table->foreignId('clave_unidad_id')->constrained('clave_unidades');
            $table->boolean('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}
