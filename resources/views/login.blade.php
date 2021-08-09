<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{$titulo}}</title>
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<div id="contenido" class="text-sm relative overflow-hidden">
				<div id="waves" class="hidden md:block absolute w-full scale-150 transform -rotate-90" style="z-index: -1; bottom: 20%; left: 25%;">
					<svg xmlns:xlink="http://www.w3.org/1999/xlink" id="wave" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 490" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(0, 48, 255, 1)" offset="0%"/><stop stop-color="rgba(102, 130, 255, 1)" offset="100%"/></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,0L26.7,57.2C53.3,114,107,229,160,261.3C213.3,294,267,245,320,204.2C373.3,163,427,131,480,163.3C533.3,196,587,294,640,294C693.3,294,747,196,800,155.2C853.3,114,907,131,960,114.3C1013.3,98,1067,49,1120,40.8C1173.3,33,1227,65,1280,138.8C1333.3,212,1387,327,1440,310.3C1493.3,294,1547,147,1600,130.7C1653.3,114,1707,229,1760,277.7C1813.3,327,1867,310,1920,318.5C1973.3,327,2027,359,2080,310.3C2133.3,261,2187,131,2240,122.5C2293.3,114,2347,229,2400,245C2453.3,261,2507,180,2560,138.8C2613.3,98,2667,98,2720,155.2C2773.3,212,2827,327,2880,351.2C2933.3,376,2987,310,3040,294C3093.3,278,3147,310,3200,294C3253.3,278,3307,212,3360,155.2C3413.3,98,3467,49,3520,89.8C3573.3,131,3627,261,3680,294C3733.3,327,3787,261,3813,228.7L3840,196L3840,490L3813.3,490C3786.7,490,3733,490,3680,490C3626.7,490,3573,490,3520,490C3466.7,490,3413,490,3360,490C3306.7,490,3253,490,3200,490C3146.7,490,3093,490,3040,490C2986.7,490,2933,490,2880,490C2826.7,490,2773,490,2720,490C2666.7,490,2613,490,2560,490C2506.7,490,2453,490,2400,490C2346.7,490,2293,490,2240,490C2186.7,490,2133,490,2080,490C2026.7,490,1973,490,1920,490C1866.7,490,1813,490,1760,490C1706.7,490,1653,490,1600,490C1546.7,490,1493,490,1440,490C1386.7,490,1333,490,1280,490C1226.7,490,1173,490,1120,490C1066.7,490,1013,490,960,490C906.7,490,853,490,800,490C746.7,490,693,490,640,490C586.7,490,533,490,480,490C426.7,490,373,490,320,490C266.7,490,213,490,160,490C106.7,490,53,490,27,490L0,490Z"/><defs><linearGradient id="sw-gradient-1" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(0, 48, 255, 1)" offset="0%"/><stop stop-color="rgba(102, 130, 255, 0.8)" offset="100%"/></linearGradient></defs><path style="transform:translate(0, 50px); opacity:0.9" fill="url(#sw-gradient-1)" d="M0,49L26.7,65.3C53.3,82,107,114,160,163.3C213.3,212,267,278,320,253.2C373.3,229,427,114,480,73.5C533.3,33,587,65,640,89.8C693.3,114,747,131,800,155.2C853.3,180,907,212,960,220.5C1013.3,229,1067,212,1120,220.5C1173.3,229,1227,261,1280,269.5C1333.3,278,1387,261,1440,220.5C1493.3,180,1547,114,1600,130.7C1653.3,147,1707,245,1760,269.5C1813.3,294,1867,245,1920,253.2C1973.3,261,2027,327,2080,318.5C2133.3,310,2187,229,2240,236.8C2293.3,245,2347,343,2400,318.5C2453.3,294,2507,147,2560,122.5C2613.3,98,2667,196,2720,212.3C2773.3,229,2827,163,2880,171.5C2933.3,180,2987,261,3040,318.5C3093.3,376,3147,408,3200,375.7C3253.3,343,3307,245,3360,171.5C3413.3,98,3467,49,3520,89.8C3573.3,131,3627,261,3680,285.8C3733.3,310,3787,229,3813,187.8L3840,147L3840,490L3813.3,490C3786.7,490,3733,490,3680,490C3626.7,490,3573,490,3520,490C3466.7,490,3413,490,3360,490C3306.7,490,3253,490,3200,490C3146.7,490,3093,490,3040,490C2986.7,490,2933,490,2880,490C2826.7,490,2773,490,2720,490C2666.7,490,2613,490,2560,490C2506.7,490,2453,490,2400,490C2346.7,490,2293,490,2240,490C2186.7,490,2133,490,2080,490C2026.7,490,1973,490,1920,490C1866.7,490,1813,490,1760,490C1706.7,490,1653,490,1600,490C1546.7,490,1493,490,1440,490C1386.7,490,1333,490,1280,490C1226.7,490,1173,490,1120,490C1066.7,490,1013,490,960,490C906.7,490,853,490,800,490C746.7,490,693,490,640,490C586.7,490,533,490,480,490C426.7,490,373,490,320,490C266.7,490,213,490,160,490C106.7,490,53,490,27,490L0,490Z"/><defs><linearGradient id="sw-gradient-2" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(0, 48, 255, 1)" offset="0%"/><stop stop-color="rgba(102, 130, 255, 0.4)" offset="100%"/></linearGradient></defs><path style="transform:translate(0, 100px); opacity:0.8" fill="url(#sw-gradient-2)" d="M0,196L26.7,163.3C53.3,131,107,65,160,40.8C213.3,16,267,33,320,32.7C373.3,33,427,16,480,57.2C533.3,98,587,196,640,245C693.3,294,747,294,800,294C853.3,294,907,294,960,269.5C1013.3,245,1067,196,1120,220.5C1173.3,245,1227,343,1280,334.8C1333.3,327,1387,212,1440,187.8C1493.3,163,1547,229,1600,269.5C1653.3,310,1707,327,1760,334.8C1813.3,343,1867,343,1920,294C1973.3,245,2027,147,2080,147C2133.3,147,2187,245,2240,302.2C2293.3,359,2347,376,2400,375.7C2453.3,376,2507,359,2560,359.3C2613.3,359,2667,376,2720,375.7C2773.3,376,2827,359,2880,351.2C2933.3,343,2987,343,3040,326.7C3093.3,310,3147,278,3200,269.5C3253.3,261,3307,278,3360,302.2C3413.3,327,3467,359,3520,310.3C3573.3,261,3627,131,3680,122.5C3733.3,114,3787,229,3813,285.8L3840,343L3840,490L3813.3,490C3786.7,490,3733,490,3680,490C3626.7,490,3573,490,3520,490C3466.7,490,3413,490,3360,490C3306.7,490,3253,490,3200,490C3146.7,490,3093,490,3040,490C2986.7,490,2933,490,2880,490C2826.7,490,2773,490,2720,490C2666.7,490,2613,490,2560,490C2506.7,490,2453,490,2400,490C2346.7,490,2293,490,2240,490C2186.7,490,2133,490,2080,490C2026.7,490,1973,490,1920,490C1866.7,490,1813,490,1760,490C1706.7,490,1653,490,1600,490C1546.7,490,1493,490,1440,490C1386.7,490,1333,490,1280,490C1226.7,490,1173,490,1120,490C1066.7,490,1013,490,960,490C906.7,490,853,490,800,490C746.7,490,693,490,640,490C586.7,490,533,490,480,490C426.7,490,373,490,320,490C266.7,490,213,490,160,490C106.7,490,53,490,27,490L0,490Z"/></svg>
				</div>
				<div class="h-screen flex justify-center items-start bg-blue-600 md:bg-transparent">
					<div class="max-w-5xl flex-1 mt-6 rounded-md overflow-hidden shadow-2xl">
						<div class="grid grid-cols-12">
							<div id="info" class="col-span-4 bg-blue-600 px-8 hidden md:block">
								<div class="flex flex-col justify-between h-full">
									<img src="/imagenes/gente_interrogacion.png" alt="Imagen de comunidad" class="pt-20 pb-20">
									<div id="invitacion-registrarse" class="pb-6">
										<span class="font-bold text-lg text-white">¿Todavía no tienes cuenta?</span>
										<p class="text-white">Registrate hoy haciendo clic <a href="/registrarse" class="underline">aquí</a>.</p>
									</div>
								</div>
							</div>
							<div id="form-contenido" class="col-span-12 bg-white px-8 py-10 md:col-span-8">
								<div class="flex justify-center mb-3">
									<img src="/imagenes/devsoverflow_logo.png" alt="Logo de DevsOverflow" style="width: 300px">
								</div>
								<div class="flex justify-center">
									<div class="flex-1 max-w-xl">
										<h1 class="text-center font-bold text-xl mt-5 mb-3">Iniciar sesión</h1>
										@if ($errors->any())
											<div class="bg-red-600 text-white px-3 py-2 rounded-md mb-2">
												@foreach($errors->all() as $error)
													<div>{{$error}}</div>
												@endforeach
											</div>
										@endif
										<form action="/api/auth/login" method="POST">
											@csrf
											<div class="flex flex-col mb-5">
												<label for="correo" class="mb-2 font-bold text-gray-700">Correo</label>
												<vue-input type="text" name="email" placeholder="Ingrese su correo"></vue-input>
											</div>
											<div class="flex flex-col mb-5">
												<label for="nombre" class="mb-2 font-bold text-gray-700">Contraseña</label>
												<vue-input type="password" name="password" placeholder="Ingrese su contraseña"></vue-input>
											</div>
											<div class="flex flex-col mb-3">
												<vue-input-submit type="submit" value="Iniciar sesión"></vue-input-submit>
											</div>
										</form>
										<p class="md:hidden text-center text-gray-600 mt-5">¿No tienes una cuenta? Registrate haciendo clic <a href="/registrarse" class="text-blue-800 underline">aquí</a>.</p>
										<p class="text-center text-gray-600 mt-5">DevsOverflow &COPY;{{ $anio_actual }}.</p>
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
