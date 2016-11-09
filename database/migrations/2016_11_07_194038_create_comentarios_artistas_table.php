<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosArtistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios_artistas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion');
            $table->integer('artista_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->dateTime('fecha');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('artista_id')
                ->references('id')->on('artistas')
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
        Schema::dropIfExists('comentarios_artistas');
    }
}
