<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancionesFavoritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canciones_favoritas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cancion_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->dateTime('fecha');
            $table->timestamps();

            // Restricción de unicidad
            $table->unique(['cancion_id', 'usuario_id']);

            // Llaves foráneas
            $table->foreign('cancion_id')
                ->references('id')->on('canciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canciones_favoritas');
    }
}
