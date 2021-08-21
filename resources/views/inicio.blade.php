@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido_principal" class="flex-1 px-3 overflow-y-scroll">
		<div class="flex justify-between items-center">
			<h5 class="font-bold text-2xl my-6">Ultimas preguntas</h5>
			<vue-anchor-button href="/pregunta/crear" texto="Crear pregunta"></vue-anchor-button>
		</div>
		@foreach($preguntas as $pregunta)
			<pregunta-en-lista
				cantidad_votos="{{ $pregunta['votos'] }}"
				cantidad_respuestas="{{ $pregunta['respuestas'] }}"
				identificador_pregunta="{{ $pregunta['identificador'] }}"
				titulo_pregunta="{{ $pregunta['pregunta'] }}"
				descripcion_pregunta="{{ $pregunta['descripcion'] }}"
				fecha_de_creacion="{{ $pregunta['created_at'] }}"
				:categorias='{!! json_encode($pregunta['categorias']) !!}'
				autor="{{ $pregunta['autor'] }}"
			>
			</pregunta-en-lista>
		@endforeach
	</div>
@stop
