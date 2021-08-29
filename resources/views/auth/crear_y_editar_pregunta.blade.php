@extends('layouts.main')

@section('contenido-principal')
	<crear-y-editar-pregunta
		csrf="{{ csrf_token() }}"
		:pregunta="{{ isset($pregunta) ? json_encode($pregunta) : '{}' }}"
		:editar="{{ isset($editar) ? $editar : "0" }}"
	></crear-y-editar-pregunta>
@stop
