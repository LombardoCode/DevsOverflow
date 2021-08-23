@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido_principal" class="flex-1 px-3 overflow-y-scroll">
		<h5 class="font-bold text-2xl my-6">Notificaciones</h5>
		<listado-notificaciones></listado-notificaciones>
	</div>
@stop
