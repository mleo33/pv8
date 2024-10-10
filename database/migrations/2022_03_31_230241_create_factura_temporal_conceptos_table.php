<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTemporalConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_temporal_conceptos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_temporal_id')->constrained('facturas_temporales');
            $table->nullableMorphs('model');
            $table->string('no_identificacion', 50);
            $table->string('descripcion');
            $table->string('clave_prod_serv', 20);
            $table->string('clave_unidad', 20);
            $table->integer('cantidad');
            $table->decimal('valor_unitario', 10, 2);
            $table->string('objeto_imp');
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
        Schema::dropIfExists('factura_temporal_conceptos');
    }
}
