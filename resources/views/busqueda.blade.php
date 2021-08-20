@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen">
			<listado-preguntas
				query="{{ $query }}"
				:sin_responder="false"
				categoria="{{ null }}"
			>
			</listado-preguntas>
		</div>
	</div>
@stop
