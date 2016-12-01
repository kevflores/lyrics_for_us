<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 50);
            $table->text('descripcion');
            $table->integer('tipo_solicitud_id')->unsigned();
            $table->integer('usuario_solicitante_id')->unsigned();
            $table->dateTime('fecha_solicitud');
            $table->integer('usuario_admin_id')->unsigned()->nullable();
            $table->dateTime('fecha_atencion')->nullable();
            $table->boolean('estado')->nullable(); //TRUE: Aceptada, FALSE: Rechazada.
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('tipo_solicitud_id')
                  ->references('id')->on('tipos_solicitudes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('usuario_solicitante_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('usuario_admin_id')
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
        Schema::dropIfExists('solicitudes');
    }
}
