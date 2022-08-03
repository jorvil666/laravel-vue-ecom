<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->string('nombre', 50);
            $table->string('descripcion', 200)->nullable();
            $table->integer('stock');
            $table->decimal('precio', $precision = 6, $scale = 2);
            $table->string('imagen', 500);
            $table->boolean('ratings');
            $table->boolean('fidelizacion');
            $table->boolean('estado');
            $table->foreign('categoria_id')->references('id')->on('categorias');
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
        Schema::dropIfExists('productos');
    }
}
