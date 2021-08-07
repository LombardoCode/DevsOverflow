<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesRespuestasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificaciones_respuestas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('usuario_causante_id');
			$table->unsignedBigInteger('pregunta_id');
			$table->unsignedBigInteger('notificacion_id');
			$table->foreign('usuario_causante_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
			$table->foreign('notificacion_id')->references('id')->on('notificaciones')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('notificaciones_respuestas');
	}
}
