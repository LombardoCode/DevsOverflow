<template>
	<div id="secciones" style="min-width: 180px" class="hidden md:block px-2 py-8 text-xs text-gray-700 h-full overflow-y-scroll">
		<div class="fixed">
			<nav>
				<ul>
					<li class="categoria mb-6 flex flex-col">
						<a href="/" class="mb-3">Inicio</a>
					</li>
					<li class="categoria mb-6 flex flex-col">
						<p class="uppercase mb-3">PÚBLICO</p>
						<a href="/categorias" class="mb-3 ml-3">Categorías</a>
						<a href="/usuarios" class="mb-3 ml-3">Usuarios</a>
						<a href="/sin-responder" class="mb-3 ml-3">Sin responder</a>
					</li>
					<li class="categoria mb-6 flex flex-col">
						<p class="uppercase mb-3">MI ACTIVIDAD</p>
						<a href="/mis_preguntas" class="mb-3 ml-3">Mis preguntas</a>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</template>

<script>
export default {

}
</script>

<style>

</style>
