<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNombresArtistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nombres_artistas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_alternativo', 100);
            $table->integer('artista_id')->unsigned();
            $table->timestamps();

            // Restricción de unicidad
            $table->unique(['nombre_alternativo', 'artista_id']);

            // Llaves foráneas
            $table->foreign('artista_id')
                ->references('id')->on('artistas')
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
        Schema::dropIfExists('nombres_artistas');
    }
}
