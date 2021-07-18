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
			<div id="contenido" class="text-sm">
        <div class="bg-gradient-to-br from-purple-700 to-purple-900 h-screen flex justify-center items-start">
          <div class="bg-white max-w-md flex-1 mt-3 rounded px-3">
            <h1 class="text-center font-bold text-xl mt-5 mb-3">Iniciar sesión</h1>
            @if ($errors->any())
              <div>
                @foreach($errors->all() as $error)
                  <div>{{$error}}</div>
                @endforeach
              </div>
            @endif
            <form action="/api/auth/login" method="POST">
              @csrf
              <div class="flex flex-col mb-3">
                <label for="correo" class="mb-1 font-bold">Correo</label>
                <vue-input type="text" name="email" placeholder="Ingrese su correo"></vue-input>
              </div>
              <div class="flex flex-col mb-3">
                <label for="nombre" class="mb-1 font-bold">Contraseña</label>
                <vue-input type="password" name="password" placeholder="Ingrese su contraseña"></vue-input>
              </div>
              <div class="flex flex-col mb-3">
                <vue-input-submit type="submit" placeholder="Ingrese nuevamente su contraseña"></vue-input-submit>
              </div>
            </form>
          </div>
        </div>
			</div>
		</div>
		<script src="{{ asset('/js/app.js') }}"></script>
	</body>
</html>
