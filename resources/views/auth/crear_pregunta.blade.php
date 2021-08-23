@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido" class="text-sm" style="padding-top: 26px;">
		<crear-pregunta
			csrf="{{ csrf_token() }}"
			:pregunta="{{ isset($pregunta) ? json_encode($pregunta) : '{}' }}"
		></crear-pregunta>
	</div>
@stop
