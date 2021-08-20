@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido" class="text-sm">
		<mostrar-pregunta csrf="{{ csrf_token() }}" pregunta_id="{{ $pregunta_id }}" :usuario="{{ Auth::check() ? Auth::user() : "{}" }}"></mostrar-pregunta>
	</div>
@stop
