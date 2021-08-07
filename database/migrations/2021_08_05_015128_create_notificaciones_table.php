<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificaciones', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('usuario_a_notificar_id');
			$table->unsignedBigInteger('evento_id');
			$table->boolean('visto')->default(false);
			$table->foreign('usuario_a_notificar_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('evento_id')->references('id')->on('eventos_notificaciones')->onDelete('cascade');
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
		Schema::dropIfExists('notificaciones');
	}
}
