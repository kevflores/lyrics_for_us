<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosReportadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_reportados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_reportado_id')->unsigned();
            $table->text('descripcion');
            $table->integer('usuario_reportante_id')->unsigned();
            $table->dateTime('fecha_reporte');
            $table->integer('usuario_admin_id')->unsigned()->nullable();
            $table->dateTime('fecha_atencion')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('usuario_reportado_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('no action')
                  ->onUpdate('cascade');

            $table->foreign('usuario_reportante_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('no action')
                  ->onUpdate('cascade');

            $table->foreign('usuario_admin_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('no action')
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
        Schema::dropIfExists('usuarios_reportados');
    }
}
