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
					<div id="secciones" style="width: 300px" class="bg-gray-400">
						<h3>Secciones</h3>
					</div>
					<div id="contenido_principal" class="flex-1 px-3">
						<h5 class="font-bold text-2xl my-6">Ultimas preguntas</h5>
						<div id="pregunta" class="flex mb-10">
							<div id="valoraciones" class="flex flex-col mr-4">
								<div class="text-center bg-blue-500 text-white px-3 py-1 rounded-md mb-2">
									<p>3</p>
									<p>voto(s)</p>
								</div>
								<div class="text-center bg-green-500 text-white px-3 py-1 rounded-md">
									<p>1</p>
									<p>respuesta(s)</p>
								</div>
							</div>
							<div>
								<div>
									<a href="#" class="text-blue-700 text-base">Tengo una pregunta relacionada a Vue.js</a>
									<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore omnis ipsa vel soluta, porro veniam officiis iste ut. Iusto ullam voluptate quae pariatur facilis vero eligendi distinctio repudiandae repellendus. Modi!</p>
								</div>
								<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
									<div id="secciones" class="flex">
										<div class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center"><a href="/categoria/vue">vue.js</a></div>
									</div>
									<div id="creador" class="flex justify-end items-center">
										<span class="text-xs text-right">Formulada el 1 de enero de 2000 por Lombardo Moreno Rodríguez.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
