<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{$titulo}}</title>
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<navbar :usuario="{{ Auth::check() ? Auth::user() : "{}" }}"></navbar>
			<div id="contenido" style="padding-top: 52px;">
				<div class="container mx-auto text-sm flex h-screen">
					@include('reusable.sidebar_cuenta')
					<div id="contenido-inner" class="w-full max-w-6xl">
						<div id="cuerpo">
							<administrar-categorias titulo="Administración de las categorias"></administrar-categorias>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
