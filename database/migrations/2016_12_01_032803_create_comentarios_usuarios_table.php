<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComentariosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descripcion');
            $table->integer('usuario_receptor_id')->unsigned();
            $table->integer('usuario_emisor_id')->unsigned();
            $table->dateTime('fecha');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('usuario_receptor_id')
                ->references('id')->on('usuarios')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_emisor_id')
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
        Schema::dropIfExists('comentarios_usuarios');
    }
}
