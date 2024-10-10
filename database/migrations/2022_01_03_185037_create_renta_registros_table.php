<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentaRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renta_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_id')->constrained('rentas');
            $table->morphs('model');
            $table->string('fua');
            $table->string('descripcion');
            $table->integer('unidades');
            $table->string('tipo_renta');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio', 10, 2);
            $table->decimal('pagado', 10, 2);
            $table->bigInteger('horometro_inicio');
            $table->bigInteger('horometro_final')->nullable();
            $table->timestamp('fecha_retorno')->nullable();
            $table->boolean('recibido');
            $table->timestamp('fecha_recibido')->nullable();
            $table->foreignId('user_recibido')->nullable()->constrained('users');
            $table->string('propietario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renta_registros');
    }
}
