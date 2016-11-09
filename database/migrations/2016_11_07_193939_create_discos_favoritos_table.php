<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscosFavoritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discos_favoritos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disco_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->dateTime('fecha');
            $table->timestamps();

            // Restricción de unicidad
            $table->unique(['disco_id', 'usuario_id']);

            // Llaves foráneas
            $table->foreign('disco_id')
                ->references('id')->on('discos')
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
        Schema::dropIfExists('discos_favoritos');
    }
}
