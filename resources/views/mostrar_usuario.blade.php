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
			<navbar></navbar>
			<div id="contenido" style="padding-top: 52px;">
				<div class="container mx-auto text-sm flex h-screen" style="height: calc(100vh - 52px)">
					<sidebar-izquierda></sidebar-izquierda>
					<div id="contenido_principal" class="flex-1 px-3 overflow-y-scroll">
						@if ($status)
							<div class="my-6">
								<div id="datos-usuario" class="flex">
									<div id="foto-perfil">
										<img src="https://www.uic.mx/posgrados/files/2018/05/default-user.png" style="width: 250px;">
									</div>
									<div id="nombre-y-descripcion" class="ml-4">
										<h5 class="font-bold text-2xl mt-6 mb-3">{{ $usuario->name }}</h5>
										<p class="w-1/2">{{ $usuario->description }}</p>
									</div>
								</div>
							</div>
							<div id="preguntas-y-respuestas" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
								<div id="preguntas">
									<h5 class="text-lg font-medium mt-6 mb-3">Últimas preguntas realizadas por este usuario:</h5>
									@foreach($preguntas as $pregunta)
										<a href="/pregunta/{{ $pregunta->identificador }}" class="bg-azul-100 hover:bg-blue-200 px-3 py-2 rounded-md block mb-2">
											<p>{{ $pregunta->pregunta }}</p>
											<p class="text-right">Formulada el {{ $pregunta->created_at }}</p>
										</a>
									@endforeach
								</div>
								<div id="respuestas">
									<h5 class="text-lg font-medium mt-6 mb-3">Últimas preguntas contestadas por este usuario:</h5>
									@foreach($preguntas_contestadas as $pregunta_contestada)
										<a href="/pregunta/{{ $pregunta_contestada->identificador }}" class="bg-azul-100 hover:bg-blue-200 px-3 py-2 rounded-md block mb-2">
											<p>{{ $pregunta_contestada->pregunta }}</p>
											<p class="text-right">Formulada el {{ $pregunta_contestada->created_at }}</p>
										</a>
									@endforeach
								</div>
							</div>
						@else
							<div class="my-6 bg-red-600 text-white py-3 px-4 rounded-md">
								Usuario no encontrado.
							</div>
						@endif
					</div>
				</div>
				<vue-footer></vue-footer>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
