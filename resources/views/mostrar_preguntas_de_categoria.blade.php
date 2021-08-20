@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen">
			<listado-preguntas
				query="{{ null }}"
				:sin_responder="false"
				categoria="{{ $categoria }}"
			>
			</listado-preguntas>
		</div>
	</div>
@stop
