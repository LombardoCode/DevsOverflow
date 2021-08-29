@extends('layouts.main')

@section('contenido-principal')
	<listado-preguntas
		titulo="Mis preguntas"
		query="{{ null }}"
		:sin_responder="false"
		categoria="{{ null }}"
		:preguntas_propias="true"
		:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
	>
	</listado-preguntas>
@stop
