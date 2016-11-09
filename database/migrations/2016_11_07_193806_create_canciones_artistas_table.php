<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancionesArtistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canciones_artistas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cancion_id')->unsigned();
            $table->integer('artista_id')->unsigned();
            $table->boolean('invitado');
            $table->timestamps();

            // Restricción de unicidad
            $table->unique(['cancion_id', 'artista_id']);

            // Llaves foráneas
            $table->foreign('cancion_id')
                ->references('id')->on('canciones')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('artista_id')
                ->references('id')->on('artistas')
                ->onDelete('restrict')
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
        Schema::dropIfExists('canciones_artistas');
    }
}
