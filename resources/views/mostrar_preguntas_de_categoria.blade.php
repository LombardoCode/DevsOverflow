@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen">
			<mostrar-preguntas-categoria categoria="{{ $categoria }}"></mostrar-preguntas-categoria>
		</div>
	</div>
@stop
