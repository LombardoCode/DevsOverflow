@extends('layouts.cuenta')

@section('contenido-principal')
	<div id="contenido-inner" class="w-full max-w-6xl">
		<div id="cuerpo">
			<div class="flex items-center justify-between">
				<h5 class="font-bold text-2xl my-6">Editar categoría</h5>
			</div>
			@include('reusable.alerta')
			<div id="formulario">
				<form action="/api/categoria/{{ $categoria->id }}" method="POST">
					@csrf
					@method('PUT')
					<div class="flex flex-col mb-5">
						<label for="nombre_categoria" class="mb-2 font-bold text-gray-700">Nombre de la categoría</label>
						<vue-input type="text" name="nombre_categoria" placeholder="Ingrese el nombre de la categoría" value="{{ $categoria->categoria }}"></vue-input>
					</div>
					<div class="flex flex-col mb-5">
						<label for="descripcion_categoria" class="mb-2 font-bold text-gray-700">Descripción de la categoría</label>
						<vue-input type="text" name="descripcion_categoria" placeholder="Ingrese el nombre de la categoría" value="{{ $categoria->descripcion }}"></vue-input>
					</div>
					<div class="flex flex-col mb-3">
						<vue-input-submit type="submit" value="Editar la categoría"></vue-input-submit>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop
