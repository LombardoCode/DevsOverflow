@extends('layouts.main')

@section('contenido-principal')
	<listado-preguntas
		titulo="Resultados de búsqueda"
		:todas="false"
		query="{{ $query }}"
		:sin_responder="false"
		categoria="{{ null }}"
		:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
	>
@stop
