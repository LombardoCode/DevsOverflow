<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('reusable.head')
	</head>
	<body>
		<div id="app">
			@include('reusable.navbar')
			<div class="flex flex-col justify-between" style="height: calc(100vh)">
				<div id="contenido" style="padding-top: 60px;">
					<div class="container mx-auto text-sm flex h-screen" style="height: 100%">
						<sidebar-izquierda></sidebar-izquierda>
						@yield('contenido-principal')
					</div>
				</div>
				<vue-footer></vue-footer>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
