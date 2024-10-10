<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->foreignId('emisor_id')->nullable()->constrained('emisores');
            $table->text('comentarios')->nullable();
            $table->text('mensaje_ticket_venta')->nullable();
            $table->text('mensaje_ticket_renta')->nullable();
            $table->decimal('tasa_iva')->default(16);
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
        Schema::dropIfExists('sucursales');
    }
}
