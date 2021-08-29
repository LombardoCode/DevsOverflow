@extends('layouts.cuenta')

@section('contenido-principal')
	<mostrar-categorias
		titulo="Administración de las categorias"
		roles="{{ Auth::user()->getRoleNames() }}"
		permisos="{{ Auth::user()->getPermissionNames() }}"
	></mostrar-categorias>
@stop
