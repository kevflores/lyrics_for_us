<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 100);
            $table->string('resumen', 255)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->text('portada')->nullable();
            $table->integer('artista_id')->unsigned();
            $table->integer('visitas')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('discos');
    }
}
