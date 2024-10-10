<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentaRegistrosTemporalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renta_registros_temporales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('renta_temporal_id')->constrained('rentas_temporales');
            $table->morphs('model');
            $table->integer('unidades');
            $table->string('tipo_renta');
            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('pagado', 10, 2);
            $table->bigInteger('horometro_inicio');
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
        Schema::dropIfExists('renta_registros_temporales');
    }
}
