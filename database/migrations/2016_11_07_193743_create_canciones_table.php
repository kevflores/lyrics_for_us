<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->nullable();
            $table->string('titulo', 100);
            $table->string('resumen', 255)->nullable();
            $table->integer('disco_id')->unsigned()->nullable();
            $table->string('autor')->nullable();
            $table->text('audio')->nullable();
            $table->text('portada')->nullable();
            $table->text('letra')->nullable();
            $table->dateTime('fecha_letra')->nullable();
            $table->integer('usuario_id')->unsigned()->nullable();
            $table->dateTime('fecha_letra_modificada')->nullable();
            $table->integer('usuario_modificador_id')->unsigned()->nullable();
            $table->integer('visitas')->default(0);
            $table->integer('visitas_letra')->default(0);
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('disco_id')
                ->references('id')->on('discos')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('usuario_modificador_id')
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
        Schema::dropIfExists('canciones');
    }
}
