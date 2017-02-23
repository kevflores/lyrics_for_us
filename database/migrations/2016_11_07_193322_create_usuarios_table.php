<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname', 20)->unique();
            $table->string('nombre', 25);
            $table->string('apellido', 25);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('resumen', 255)->nullable();
            $table->string('url')->nullable();
            $table->string('ubicacion')->nullable();
            $table->integer('visitas')->default(0);
            $table->char('genero', 1)->default('I');
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(false);
            $table->boolean('permiso')->default(true);
            $table->integer('categoria_usuario_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('categoria_usuario_id')
                  ->references('id')->on('categorias_usuarios')
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
        Schema::dropIfExists('usuarios');
    }
}
