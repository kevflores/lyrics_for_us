<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetrasReportadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letras_reportadas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion');
            $table->integer('cancion_id')->unsigned();
            $table->integer('usuario_reportante_id')->unsigned();
            $table->dateTime('fecha_reporte');
            $table->integer('usuario_admin_id')->unsigned()->nullable();
            $table->dateTime('fecha_atencion')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('cancion_id')
                ->references('id')->on('canciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_reportante_id')
                ->references('id')->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_admin_id')
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
        Schema::dropIfExists('letras_reportadas');
    }
}
