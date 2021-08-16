<div id="secciones" style="min-width: 180px" class="hidden md:block px-2 py-8 text-xs text-gray-700">
	<div class="fixed bg-red-300">
		<nav>
			<ul>
				<div class="categoria mb-6">
					<p class="uppercase mb-3">Cuenta</p>
					<li class="mb-3 ml-3"><a href="/ajustes/mis-datos">Datos personales</a></li>
				</div>
				@role('administrador')
					<div class="categoria">
						<p class="uppercase mb-3">Administrador</p>
						@can('crear-categorias')
							<li class="mb-3 ml-3"><a href="/ajustes/categorias">Crear categorías</a></li>
						@endcan
					</div>
				@endrole
			</ul>
		</nav>
	</div>
</div>
