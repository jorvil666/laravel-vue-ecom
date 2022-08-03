<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('descripcion', 200);
            $table->string('direccion', 200);
            $table->string('email', 200);
            $table->string('telefono', 50);
            $table->integer('impuesto');
            $table->integer('delivery');
            $table->boolean('fidelizacion');
            $table->boolean('estado');
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
        Schema::dropIfExists('empresa');
    }
}
