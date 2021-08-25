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
					:index="index"
					:pregunta="pregunta"
					:mismo_autor="usuario.id === pregunta.user_id"
					:usuario="usuario"
					@indexRecursoEliminado="indexRecursoEliminado"
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
		usuario: Object,
		todas: Boolean,
		query: String,
		sin_responder: Boolean,
		categoria: String,
		preguntas_propias: Boolean
	},
	data() {
		return {
			preguntas: [],
			paginacion: {
				todas: this.todas,
				query: this.query,
				sin_responder: this.sin_responder,
				categoria: this.categoria,
				preguntas_propias: this.preguntas_propias,
				filtro: 'mas_reciente',
				pagina: 0,
				itemsMaxPorPag: 10,
				totalItems: 0
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
		},
		indexRecursoEliminado(index_recurso) {
			// Eliminamos localmente la categoría deseada
			this.preguntas.splice(index_recurso, 1);

			// Realizamos la búsqueda nuevamente
			this.paginacion.pagina = 0;
			this.realizarBusqueda();
		}
	}
}
</script>

<style>

</style>
