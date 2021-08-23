@extends('layouts.cuenta')

@section('contenido-principal')
	<div id="contenido" class="w-full max-w-6xl">
		<div id="cuerpo">
			<mostrar-categorias
				titulo="Administración de las categorias"
				roles="{{ Auth::user()->getRoleNames() }}"
				permisos="{{ Auth::user()->getPermissionNames() }}"
			></mostrar-categorias>
		</div>
	</div>
@stop
