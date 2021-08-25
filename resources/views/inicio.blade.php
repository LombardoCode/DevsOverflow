@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido_principal" class="flex-1 px-3 overflow-y-scroll">
		<listado-preguntas
			:todas="true"
			:query="''"
			:sin_responder="false"
			categoria="{{ null }}"
			:usuario="{{ Auth::check() ? Auth::user() : '{}' }}"
		></listado-preguntas>
	</div>
@stop
