<template>
	<footer class="w-full bg-footer text-white mt-20">
		<div class="container mx-auto py-10">
			<div class="flex flex-col md:flex-row justify-between items-center">
				<img
					id="logo"
					src="/svg/devsoverflow_blanco.svg"
					class="w-full px-10 mb-6 md:mb-0 md:px-0 md:w-2/4 lg:w-2/5 xl:w-2/6"
					alt=""
				>
				<div id="items" class="text-sm">
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
				</div>
			</div>
		</div>
		<div id="datos-creador" class="bg-black text-center py-2">
			<p>Este sitio web fué desarrollado por Lombardo Moreno Rodríguez - 2021</p>
		</div>
	</footer>
</template>

<script>
import SidebarIzquierda from '../elementos_layout/SidebarIzquierda.vue'
export default {
	components: {
		SidebarIzquierda
	}
}
</script>

<style scoped>
	.bg-footer {
		background-color: #252525;
	}
</style>
