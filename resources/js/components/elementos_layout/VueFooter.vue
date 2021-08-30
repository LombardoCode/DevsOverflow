<template>
	<footer class="w-full bg-footer text-white mt-20">
		<div class="container mx-auto py-10">
			<div class="flex flex-col md:flex-row justify-between items-center">
				<div id="logo" class="w-full px-10 mb-6 md:mb-0 md:px-0 md:w-2/4 lg:w-2/5 xl:w-2/6">
					<img src="/imagenes/devsoverflow_logo.png" alt="">
				</div>
				<div id="items" class="text-sm">
					<ul>
						<div class="categoria mb-6">
							<li class="mb-3"><a href="/">Inicio</a></li>
						</div>
						<div class="categoria mb-6">
							<p class="uppercase mb-3">PÚBLICO</p>
							<li class="mb-3 ml-3"><a href="/categorias">Categorías</a></li>
							<li class="mb-3 ml-3"><a href="/usuarios">Usuarios</a></li>
							<li class="mb-3 ml-3"><a href="/sin-responder">Sin responder</a></li>
						</div>
						<div class="categoria mb-6">
							<p class="uppercase mb-3">MI ACTIVIDAD</p>
							<li class="mb-3 ml-3"><a href="/mis_preguntas">Mis preguntas</a></li>
						</div>
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
