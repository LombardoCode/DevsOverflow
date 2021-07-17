<div class="w-full bg-gray-300 py-3 text-sm">
	<div class="container mx-auto flex justify-between">
		<div id="logo">Logo</div>
		<div id="navbar-items">
			<ul class="flex">
				@auth
					<li class="mr-3"><a href="/registrarse">Bienvenido {{ Auth::user()->name }}</a></li>
				@else
					<li class="mr-3"><a href="/registrarse">Registrarse</a></li>
					<li><a href="/login">Iniciar sesión</a></li>
				@endauth
			</ul>
		</div>
	</div>
</div>
