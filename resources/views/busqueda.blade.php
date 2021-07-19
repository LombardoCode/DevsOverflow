<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{$titulo}}</title>
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			@include('reusable.navbar')
			<div id="contenido">
				<div class="container mx-auto text-sm flex h-screen">
					<div id="secciones" style="width: 300px" class="bg-gray-400 hidden md:block">
						<h3>Secciones</h3>
					</div>
					<seccion-preguntas :preguntas="{{ $preguntas }}" query="{{ $query }}"></seccion-preguntas>
				</div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
