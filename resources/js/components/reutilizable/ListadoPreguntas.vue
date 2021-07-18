<template>
	<div>
		<div id="contenido_principal" class="flex-1 px-3">
			<div class="flex justify-between items-center">
				<h5 class="font-bold text-2xl my-6">Resultados de búsqueda</h5>
				<vue-anchor-button href="/pregunta/crear" texto="Crear pregunta"></vue-anchor-button>
			</div>
			<p class="text-gray-600 mb-4">Resultados para {{ query }}</p>
			<div id="header-resultados-filtros" class="flex justify-between items-center mb-3">
				<span class="text-lg font-medium">310 resultados</span>
				<div class="flex flex-wrap ring-1 ring-gray-600 rounded">
					<button class="px-3 py-2 border-r-2 border-gray-600">Relevancia</button>
					<button class="px-3 py-2 border-r-2 border-gray-600">Más reciente</button>
					<button class="px-3 py-2 border-r-2 border-gray-600">Votos</button>
					<button class="px-3 py-2 border-gray-600">Activo</button>
				</div>
			</div>
			<div id="pregunta" class="flex mb-10">
				<div id="valoraciones" class="flex flex-col mr-4">
					<div class="text-center bg-blue-500 text-white px-3 py-1 rounded-md mb-2">
						<p>3</p>
						<p>voto(s)</p>
					</div>
					<div class="text-center bg-green-600 text-white px-3 py-1 rounded-md">
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
</template>

<script>
export default {
	props: {
		query: String,
		preguntas: []
	},
	mounted() {
		console.log(this.preguntas)
	}
}
</script>

<style>

</style>
