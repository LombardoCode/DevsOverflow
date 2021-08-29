@extends('layouts.main')

@section('contenido-principal')
	<listado-preguntas
		titulo="{{ 'Preguntas sobre "' . $categoria . '"' }}"
		query="{{ null }}"
		:sin_responder="false"
		categoria="{{ $categoria }}"
		:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
	>
	</listado-preguntas>
@stop
