<template>
	<div id="pregunta" class="flex flex-col lg:flex-row mb-12 w-full">
		<div id="valoraciones" class="flex flex-col sm:flex-row lg:flex-col  items-stretch lg:mr-4 order-2 lg:order-none">
			<div class="flex-1 lg:flex-initial text-center bg-blue-500 text-white px-3 py-1 rounded-md lg:mb-2 mb-2 sm:mb-0 sm:mr-1 lg:mr-0">
				<p>{{ pregunta.votos }}</p>
				<p>voto(s)</p>
			</div>
			<div class="flex-1 lg:flex-initial text-center bg-green-500 text-white px-3 py-1 rounded-md sm:ml-1 lg:ml-0">
				<p>{{ pregunta.respuestas }}</p>
				<p>respuesta(s)</p>
			</div>
		</div>
		<div class="w-full">
			<div class="flex items-start">
				<a :href="`/pregunta/${pregunta.identificador}`" class="flex-1 text-blue-700 text-base">{{ pregunta.pregunta }}</a>
				<div v-if="mismo_autor || usuario.id === pregunta.user_id" class="flex">
					<a id="editar" :href="`/pregunta/${pregunta.identificador}/editar`" class="bg-blue-600 hover:bg-blue-700 transition-all duration-200 text-white px-4 lg:px-2 py-3 lg:py-2 rounded-md mr-1 cursor-pointer">
						<span class="hidden lg:inline-block">Editar</span>
						<font-awesome-icon icon="edit" class="lg:hidden"/>
					</a>
					<div id="eliminar" class="bg-red-600 hover:bg-red-700 transition-all duration-200 text-white px-4 lg:px-2 py-3 lg:py-2 rounded-md cursor-pointer" @click="abrirModal(pregunta, index)">
						<span class="hidden lg:inline-block">Eliminar</span>
						<font-awesome-icon icon="trash-alt" class="lg:hidden"/>
					</div>
				</div>
			</div>
			<p>{{ pregunta.descripcion }}</p>
			<div id="secciones-y-creador" class="grid grid-cols-12 mt-2">
				<div id="secciones" class="col-span-12 flex flex-wrap  items-end mb-2">
					<div v-for="(categoria, index) in pregunta.categorias" :key="index" class="text-sm mr-2 mb-2 bg-blue-200 hover:bg-blue-300 transition-all duration-100 text-blue-600 rounded flex justify-center items-center">
						<a :href="`/categorias/${categoria.categoria}`" class="px-3 py-2">{{categoria.categoria}}</a>
					</div>
				</div>
				<div id="creador" class="col-span-12 flex flex-col justify-center items-end mb-3 lg:mb-0">
					<span class="text-xs text-right mb-1">Formulada por <a :href="`/usuarios/${pregunta.autor.id}`" class="text-blue-600">{{ pregunta.autor.nombre }}</a>.</span>
					<span class="text-xs text-right">{{ pregunta.created_at }}.</span>
				</div>
			</div>
		</div>
		<modal-eliminar v-if="modal.mostrar" :datos="modal.datos" :API_URL="`/api/pregunta/${modal.datos.id}`" @cerrarModal="cerrarModal()" @indexRecursoEliminado="indexRecursoEliminado"></modal-eliminar>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faTrashAlt } from '@fortawesome/free-solid-svg-icons'

library.add(faEdit, faTrashAlt)

export default {
	props: {
		index: Number,
		pregunta: Object,
		categorias: Array,
		mismo_autor: Boolean,
		usuario: Object
	},
	data() {
		return {
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
	methods: {
		abrirModal(datos, index) {
			console.log(datos);
			this.modal = {
				mostrar: true,
				datos: {
					id: datos.id,
					index,
					titulo: 'Eliminar pregunta',
					cuerpo: '¿Desea eliminar la pregunta?',
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
			// Emitimos una señal al componente padre para eliminar el index del recurso localmente
			this.$emit('indexRecursoEliminado', index_recurso);
		}
	}
}
</script>

<style>

</style>
