@extends('layouts.main')

@section('contenido-principal')
	<listado-preguntas
		titulo="Preguntas sin responder"
		query="{{ null }}"
		:sin_responder="true"
		categoria="{{ null }}"
		:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
	>
	</listado-preguntas>
@stop
