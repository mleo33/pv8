<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmisoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emisores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('rfc', 15);
            $table->string('regimen_fiscal', 5);
            $table->string('lugar_expedicion', 15);
            $table->string('serie', 6);
            $table->string('serie_complementos', 6);
            $table->integer('folio_facturas')->default(1);
            $table->integer('folio_complementos')->default(1);
            $table->string('no_certificado', 50);
            $table->string('clave_certificado', 50);
            $table->string('fd_user', 50);
            $table->string('fd_pass', 50);
            $table->binary('cer')->nullable();
            $table->binary('key')->nullable();
            $table->binary('pem')->nullable();
            $table->binary('pfx')->nullable();
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
        Schema::dropIfExists('emisores');
    }
}
