<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConteoFisicoTable extends Migration
{

    public function up()
    {
        Schema::create('conteo_fisico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('efectivo', 10, 2);
            $table->decimal('tarjeta', 10, 2);
            $table->decimal('transferencia', 10, 2);
            $table->decimal('cheque', 10, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conteo_fisico');
    }
}
