<template>
	<div>
		<div id="categorias">
			<div class="flex items-center justify-between">
				<h5 class="font-bold text-2xl my-6">Categorías</h5>
				<vue-input class="max-w-md" v-model="paginacion.query" @input="busquedaEscrita()" placeholder="Buscar una categoria..."></vue-input>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
				<div v-for="(categoria, index) in categorias" :key="index" class="usuario bg-azul-100 hover:bg-blue-200 px-3 py-4 rounded">
					<a :href="`/categorias/${categoria.categoria}`">
						<p class="ml-3 text-base mb-1 font-bold">{{categoria.categoria}}</p>
						<p class="ml-3 text-xs italic">{{categoria.descripcion}}</p>
					</a>
				</div>
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
	data() {
		return {
			categorias: [],
			paginacion: {
				query: '',
				filtro: 'todos',
				pagina: 0,
				itemsMaxPorPag: 30,
				totalItems: 0
			}
		}
	},
	mounted() {
		this.obtenerCategorias();
	},
	methods: {
		obtenerCategorias() {
			axios.post('/api/categoria', this.paginacion)
			.then(res => {
				console.log(res.data);
				if (res.data.status) {
					this.categorias = res.data.categorias;
					this.paginacion.totalItems = res.data.cantidad_de_categorias;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		busquedaEscrita() {
			this.paginacion.pagina = 0;
			this.obtenerCategorias();
		},
		desdePaginacion(datos) {
			this.paginacion.pagina = datos.pagina;
			this.paginacion.itemsMaxPorPag = datos.itemsMaxPorPag;
			this.paginacion.totalItems = datos.totalItems;
			this.obtenerCategorias();
		},
		cambiarFiltro(filtro) {
			this.paginacion.pagina = 0;
			this.paginacion.filtro = filtro;
			this.obtenerCategorias();
		},
	}
}
</script>

<style>

</style>
