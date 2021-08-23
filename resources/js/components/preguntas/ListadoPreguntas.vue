<template>
	<div class="w-full">
		<div id="contenido_principal" class="flex-1 px-3">
			<div class="flex justify-between items-center">
				<h5 class="font-bold text-2xl my-6">Resultados de búsqueda</h5>
				<vue-anchor-button href="/pregunta/crear" texto="Crear pregunta"></vue-anchor-button>
			</div>
			<p class="text-gray-600 mb-4">Resultados para {{ query }}</p>
			<div id="header-resultados-filtros" class="flex justify-between items-center mb-3">
				<span class="text-lg font-medium">{{ paginacion.totalItems }} resultados</span>
				<div class="flex flex-wrap ring-1 ring-gray-600 rounded">
					<span>{{paginacion.filtros}}</span>
					<button class="px-3 py-2 border-r-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'mas_reciente'}" @click="cambiarFiltro('mas_reciente')">Más reciente</button>
					<button class="px-3 py-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'votos'}" @click="cambiarFiltro('votos')">Votos</button>
				</div>
			</div>
			<div id="preguntas">
				<pregunta-en-lista
					v-for="(pregunta, index) in preguntas" :key="index"
					:cantidad_votos="pregunta.votos"
					:cantidad_respuestas="pregunta.respuestas"
					:identificador_pregunta="pregunta.identificador"
					:titulo_pregunta="pregunta.pregunta"
					:descripcion_pregunta="pregunta.descripcion"
					:fecha_de_creacion="pregunta.created_at"
					:autor="pregunta.autor"
				>
				</pregunta-en-lista>
			</div>
			<paginacion
				:pagina="paginacion.pagina"
				:itemsMaxPorPag="paginacion.itemsMaxPorPag"
				:totalItems="paginacion.totalItems"
				v-on:datosDesdePaginacion="desdePaginacion">
			</paginacion>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		query: String,
		sin_responder: Boolean,
		categoria: String
	},
	data() {
		return {
			preguntas: [],
			paginacion: {
				query: this.query,
				sin_responder: this.sin_responder,
				categoria: this.categoria,
				filtro: 'mas_reciente',
				pagina: 0,
				itemsMaxPorPag: 3,
				totalItems: 0
			}
		}
	},
	mounted() {
		console.log("Inicio de props")
		console.log(this.query)
		console.log(this.sin_responder)
		console.log(this.categoria)
		console.log("Fin de props")
		this.realizarBusqueda();
	},
	methods: {
		realizarBusqueda() {
			axios.post('/api/busqueda', this.paginacion)
			.then(res => {
				console.log(res.data)
				this.preguntas = res.data.preguntas;
				this.paginacion.totalItems = res.data.cantidad_de_preguntas;
			})
			.catch(err => {
				console.log(err);
			})
		},
		cambiarFiltro(filtro) {
			this.paginacion.filtro = filtro;
			this.realizarBusqueda();
		},
		desdePaginacion(datos) {
			this.paginacion.pagina = datos.pagina;
			this.paginacion.itemsMaxPorPag = datos.itemsMaxPorPag;
			this.paginacion.totalItems = datos.totalItems;
			this.realizarBusqueda();
		}
	}
}
</script>

<style>

</style>
