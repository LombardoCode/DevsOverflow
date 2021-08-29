<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('reusable.head')
	</head>
	<body>
		<div id="app">
			@include('reusable.navbar')
			<div id="contenido" style="padding-top: 66px;">
				<div class="container mx-auto text-sm flex h-screen" style="height: calc(100vh - 52px)">
					<sidebar-izquierda></sidebar-izquierda>
					@yield('contenido-principal')
				</div>
				<vue-footer></vue-footer>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
