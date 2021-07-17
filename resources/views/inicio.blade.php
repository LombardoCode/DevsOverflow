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
				<div class="container mx-auto text-sm">
					<h1>Bienvenido al sitio web.</h1>
				</div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
