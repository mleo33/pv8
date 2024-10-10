<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('emisor_id')->constrained('emisores');
            $table->foreignId('entidad_fiscal_id')->constrained('entidades_fiscales');
            $table->nullableMorphs('model');
            $table->string('tipo', 15);
            $table->string('forma_pago', 15);
            $table->string('serie', 6);
            $table->integer('folio');
            $table->decimal('tasa_iva', 6, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('uuid', 50);
            $table->text('xml');
            $table->string('estatus', 20);
            $table->string('comentarios');
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
        Schema::dropIfExists('facturas');
    }
}
