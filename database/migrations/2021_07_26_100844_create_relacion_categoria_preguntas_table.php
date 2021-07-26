<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacionCategoriaPreguntasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relacion_categoria_preguntas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('categoria_id');
			$table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
			$table->unsignedBigInteger('pregunta_id');
			$table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
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
		Schema::dropIfExists('relacion_categoria_preguntas');
	}
}
