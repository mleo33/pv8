<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntidadesFiscalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades_fiscales', function(Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('razon_social');
            $table->string('regimen_fiscal', 5);
            $table->string('calle')->nullable();
            $table->string('numero')->nullable();
            $table->string('numero_int')->nullable();
            $table->string('colonia')->nullable();
            $table->string('cp')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado')->nullable();
            $table->string('rfc')->nullable();
            $table->string('correo')->nullable();
            $table->string('comentarios')->nullable();
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
        Schema::dropIfExists('entidades_fiscales');
    }
}
