@extends('layouts.main')

@section('contenido-principal')
	<mostrar-categorias
		titulo="Administración de las categorias"
		roles="{{ Auth::check() ? Auth::user()->getRoleNames() : null }}"
		permisos="{{ Auth::check() ? Auth::user()->getPermissionNames() : null }}"
	>
	</mostrar-categorias>
@stop
