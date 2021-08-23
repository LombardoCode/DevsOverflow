@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen">
			<listado-preguntas
				query="{{ null }}"
				:sin_responder="false"
				categoria="{{ null }}"
				:preguntas_propias="true"
				:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
			>
			</listado-preguntas>
		</div>
	</div>
@stop