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
				<div class="container mx-auto text-sm flex h-screen">
					@include('reusable.sidebar_cuenta')
					<div id="contenido-inner" class="w-full max-w-3xl">
						<div id="heading">
							<h5 class="font-bold text-2xl my-6">Datos del usuario</h5>
							@include('reusable.alerta')
						</div>
						<div id="cuerpo">
							<div id="formulario">
								<form action="/api/usuario" method="POST">
									@csrf
									@method('PUT')
									<div class="flex flex-col mb-5">
										<label for="nombre" class="mb-2 font-bold text-gray-700">Nombre</label>
										<vue-input type="text" name="nombre" placeholder="Ingrese su nombre" value="{{ $usuario->name }}"></vue-input>
									</div>
									<div class="flex flex-col mb-5">
										<label for="correo" class="mb-2 font-bold text-gray-700">Correo</label>
										<vue-input type="email" name="email" placeholder="Ingrese su correo" value="{{ $usuario->email }}"></vue-input>
									</div>
									<div class="flex flex-col mb-5">
										<label for="bio" class="mb-2 font-bold text-gray-700">Descripción (opcional)</label>
										<textarea name="bio" id="bio" cols="30" rows="6" class="w-full px-3 py-2 rounded-md placeholder-gray-400 ring-2 ring-blue-500 outline-none" placeholder="Ingrese una descripción de perfil">{{ $usuario->description }}</textarea>
									</div>
									<vue-input-submit texto="Editar datos" placeholder="asdklasd"></vue-input-submit>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
