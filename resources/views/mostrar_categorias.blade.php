@extends('layouts.main')

@section('contenido-principal')
	<div id="contenido">
		<div class="container mx-auto text-sm flex h-screen" style="height: calc(100vh - 52px)">
			<div id="contenido_principal" class="flex-1 px-3 overflow-y-scroll">
				<mostrar-categorias titulo="Administración de las categorias"></mostrar-categorias>
			</div>
		</div>
		<vue-footer></vue-footer>
	</div>
@stop
