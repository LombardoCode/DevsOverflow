<template>
	<div class="w-full">
		<div id="contenido_principal" class="flex-1 px-3">
			<div class="flex justify-between items-center">
				<h5 class="font-bold text-2xl my-6">Resultados de búsqueda</h5>
				<vue-anchor-button href="/pregunta/crear" texto="Crear pregunta"></vue-anchor-button>
			</div>
			<p class="text-gray-600 mb-4">Resultados para {{ query }}</p>
			<div id="header-resultados-filtros" class="flex justify-between items-center mb-3">
				<span class="text-lg font-medium">310 resultados</span>
				<div class="flex flex-wrap ring-1 ring-gray-600 rounded">
					<span>{{paginacion.filtros}}</span>
					<button class="px-3 py-2 border-r-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'relevancia'}" @click="cambiarFiltro('relevancia')">Relevancia</button>
					<button class="px-3 py-2 border-r-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'mas_reciente'}" @click="cambiarFiltro('mas_reciente')">Más reciente</button>
					<button class="px-3 py-2 border-r-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'votos'}" @click="cambiarFiltro('votos')">Votos</button>
					<button class="px-3 py-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'activo'}" @click="cambiarFiltro('activo')">Activo</button>
				</div>
			</div>
			<div id="preguntas">
				<div id="pregunta" class="flex mb-10" v-for="(pregunta, index) in preguntas" :key="index">
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
							<a :href="`/pregunta/${pregunta.identificador}`" class="text-blue-700 text-base">{{pregunta.pregunta}}</a>
							<p>{{pregunta.descripcion}}</p>
						</div>
						<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
							<div id="secciones" class="flex">
								<div class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center"><a href="/categoria/vue">vue.js</a></div>
							</div>
							<div id="creador" class="flex justify-end items-center">
								<span class="text-xs text-right">Formulada el {{ pregunta.created_at }} por Lombardo Moreno Rodríguez.</span>
							</div>
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
	},
	data() {
		return {
			preguntas: [],
			paginacion: {
				filtro: 'mas_reciente',
				pagina: 0,
				itemsMaxPorPag: 3,
				query: this.query
			}
		}
	},
	mounted() {
		this.realizarBusqueda();
	},
	methods: {
		realizarBusqueda() {
			axios.post('/api/busqueda', this.paginacion)
			.then(res => {
				console.log(res.data);
				this.preguntas = res.data;
			})
			.catch(err => {
				console.log(err);
			})
		},
		cambiarFiltro(filtro) {
			this.paginacion.filtro = filtro;
			this.realizarBusqueda();
		}
	}
}
</script>

<style>

</style>
