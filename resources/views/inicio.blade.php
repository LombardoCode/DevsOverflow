@extends('layouts.main')

@section('contenido-principal')
	<listado-preguntas
		titulo="Últimas preguntas"
		:todas="true"
		:query="''"
		:sin_responder="false"
		categoria="{{ null }}"
		:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
	></listado-preguntas>
@stop
