<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asunto', 100);
            $table->text('descripcion');
            $table->dateTime('fecha');
            $table->boolean('estado_receptor')->default(true); // Es FALSE si el receptor elimina el mensaje.
            $table->boolean('estado_emisor')->default(true); // Es FALSE si el emisor elimina el mensaje.
            $table->boolean('visto')->default(false); // Es TRUE después de que el receptor consulta el mensaje.
            $table->integer('usuario_receptor_id')->unsigned();
            $table->integer('usuario_emisor_id')->unsigned();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('usuario_receptor_id')
                  ->references('id')->on('usuarios')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('usuario_emisor_id')
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
        Schema::dropIfExists('mensajes');
    }
}
