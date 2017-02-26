<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancionesLetrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canciones_letras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cancion_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->text('letra');
            $table->dateTime('fecha_letra');
            $table->dateTime('fecha_letra_modificada')->nullable();
            $table->integer('visitas')->default(0);
            $table->boolean('usuario_proveedor');
            $table->timestamps();

            // Restricción de unicidad
            $table->unique(['cancion_id', 'usuario_id']);

            // Llaves foráneas
            $table->foreign('cancion_id')
                ->references('id')->on('canciones')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
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
        //
    }
}
