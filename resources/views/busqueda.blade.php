@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen">
			<listado-preguntas
				:todas="false"
				query="{{ $query }}"
				:sin_responder="false"
				categoria="{{ null }}"
				:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
			>
			</listado-preguntas>
		</div>
	</div>
@stop
