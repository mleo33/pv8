<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTemporalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_temporales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('entidad_fiscal_id')->nullable()->constrained('entidades_fiscales');
            $table->nullableMorphs('model');
            $table->decimal('tasa_iva', 6, 2);
            $table->boolean('desglosar_iva');
            $table->string('tipo_comprobante', 5);
            $table->string('forma_pago', 15);
            $table->string('metodo_pago', 15);
            $table->string('exportacion', 5);
            $table->string('uso_cfdi');
            $table->text('xml')->nullable();
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
        Schema::dropIfExists('facturas_temporales');
    }
}
