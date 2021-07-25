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
						<h5 class="font-bold text-2xl my-6">Ultimas preguntas</h5>
						@foreach($preguntas as $pregunta)
							<div id="pregunta" class="flex mb-10">
								<div id="valoraciones" class="flex flex-col mr-4">
									<div class="text-center bg-blue-500 text-white px-3 py-1 rounded-md mb-2">
										<p>{{ $pregunta['votos'] }}</p>
										<p>voto(s)</p>
									</div>
									<div class="text-center bg-green-500 text-white px-3 py-1 rounded-md">
										<p>{{ $pregunta['respuestas'] }}</p>
										<p>respuesta(s)</p>
									</div>
								</div>
								<div>
									<div>
										<a href="/pregunta/{{ $pregunta['identificador'] }}" class="text-blue-700 text-base">{{ $pregunta['pregunta'] }}</a>
										<p>{{ $pregunta['descripcion'] }}</p>
									</div>
									<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
										<div id="secciones" class="flex">
											<div class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center"><a href="/categoria/vue">vue.js</a></div>
										</div>
										<div id="creador" class="flex justify-end items-center">
											<span class="text-xs text-right">Formulada el {{ $pregunta['created_at'] }} por {{ $pregunta['autor'] }}.</span>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
				<vue-footer></vue-footer>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
