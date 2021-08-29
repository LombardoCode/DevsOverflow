<template>
	<div id="categorias" class="flex-1 px-3 overflow-y-scroll">
		<h5 class="font-bold text-2xl my-6">{{ titulo }}</h5>
		<div class="flex flex-col lg:flex-row items-center mb-3">
			<vue-input class="flex-1 lg:mr-2" v-model="paginacion.query" @input="busquedaEscrita()" placeholder="Buscar una categoria..."></vue-input>
			<a href="/ajustes/categorias/crear" class="mt-3 lg:mt-0 w-full lg:w-auto font-bold bg-blue-600 hover:bg-blue-700 transition duration-100 text-white px-3 py-4 lg:py-2 rounded-md flex items-center justify-center">
				<div class="text-lg mr-2">
					<font-awesome-icon icon="plus"/>
				</div>
				<span>Crear categoría</span>
			</a>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
			<div v-for="(categoria, index) in categorias" :key="index" class="usuario bg-azul-100 hover:bg-blue-200 px-3 py-4 rounded flex justify-between items-center">
				<div class="flex items-center justify-between w-full">
					<a :href="`/categorias/${categoria.categoria}`">
						<p class="ml-3 text-base mb-1 font-bold">{{categoria.categoria}}</p>
						<p class="ml-3 text-xs italic">{{categoria.descripcion}}</p>
					</a>
					<div v-if="roles.includes('administrador') && permisos.includes('crear-categorias')" class="opciones ml-3 flex">
						<a :href="`/ajustes/categorias/${categoria.id}`" class="px-2 py-1 text-lg bg-blue-500 rounded text-white mr-1">
							<font-awesome-icon icon="edit"/>
						</a>
						<div class="px-2 py-1 text-lg bg-red-500 rounded text-white cursor-pointer" @click="abrirModal(categoria, index)">
							<font-awesome-icon icon="trash-alt"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<paginacion
			:pagina="paginacion.pagina"
			:itemsMaxPorPag="paginacion.itemsMaxPorPag"
			:totalItems="paginacion.totalItems"
			v-on:datosDesdePaginacion="desdePaginacion">
		</paginacion>
		<modal-eliminar v-if="modal.mostrar" :datos="modal.datos" :API_URL="`/api/categoria/${modal.datos.id}`" @cerrarModal="cerrarModal()" @indexRecursoEliminado="indexRecursoEliminado"></modal-eliminar>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faTrashAlt, faPlus } from '@fortawesome/free-solid-svg-icons'

library.add(faEdit, faTrashAlt, faPlus)

export default {
	props: {
		titulo: String,
		roles: [],
		permisos: []
	},
	data() {
		return {
			categorias: [],
			paginacion: {
				query: '',
				filtro: 'todos',
				pagina: 0,
				itemsMaxPorPag: 30,
				totalItems: 0
			},
			modal: {
				mostrar: false,
				datos: {
					id: null,
					titulo: null,
					cuerpo: null
				},
			}
		}
	},
	mounted() {
		this.obtenerCategorias();
	},
	methods: {
		obtenerCategorias() {
			axios.post('/api/categoria/obtener_categorias', this.paginacion)
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
		abrirModal(datos, index) {
			console.log(datos);
			this.modal = {
				mostrar: true,
				datos: {
					id: datos.id,
					index,
					titulo: 'Eliminar categoría',
					cuerpo: '¿Desea eliminar la categoría?',
				}
			}
		},
		cerrarModal() {
			this.modal = {
				mostrar: false,
				datos: {
					id: null,
					index: null,
					titulo: null,
					cuerpo: null
				}
			}
		},
		indexRecursoEliminado(index_recurso) {
			// Eliminamos localmente la categoría deseada
			this.categorias.splice(index_recurso, 1);
		}
	}
}
</script>

<style>

</style>
