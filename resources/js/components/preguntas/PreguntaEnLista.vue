<template>
	<div id="pregunta" class="flex mb-10 w-full">
		<div id="valoraciones" class="flex flex-col mr-4">
			<div class="text-center bg-blue-500 text-white px-3 py-1 rounded-md mb-2">
				<p>{{ pregunta.votos }}</p>
				<p>voto(s)</p>
			</div>
			<div class="text-center bg-green-500 text-white px-3 py-1 rounded-md">
				<p>{{ pregunta.respuestas }}</p>
				<p>respuesta(s)</p>
			</div>
		</div>
		<div class="w-full">
			<div>
				<div class="flex">
					<a :href="`/pregunta/${pregunta.identificador}`" class="flex-1 text-blue-700 text-base">{{ pregunta.pregunta }}</a>
					<div v-if="mismo_autor || usuario.id === pregunta.user_id" class="flex">
						<a id="editar" :href="`/pregunta/${pregunta.identificador}/editar`" class="bg-blue-600 hover:bg-blue-700 transition-all duration-200 text-white px-2 py-2 rounded-md mr-1 cursor-pointer">
							Editar
						</a>
						<div id="eliminar" class="bg-red-600 hover:bg-red-700 transition-all duration-200 text-white px-2 py-2 rounded-md cursor-pointer" @click="abrirModal(pregunta, index)">
							Eliminar
						</div>
					</div>
				</div>
				<p>{{ pregunta.descripcion }}</p>
			</div>
			<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
				<div id="secciones" class="flex">
					<div v-for="(categoria, index) in categorias" :key="index" class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center">
						<a :href="`/categorias/${categoria}`">{{categoria}}</a>
					</div>
				</div>
				<div id="creador" class="flex flex-col justify-center items-end">
					<span class="text-xs text-right mb-1">Formulada por <a :href="`/usuarios/${pregunta.autor.id}`" class="text-blue-600">{{ pregunta.autor.nombre }}</a>.</span>
					<span class="text-xs text-right">{{ pregunta.created_at }}.</span>
				</div>
			</div>
		</div>
		<modal-eliminar v-if="modal.mostrar" :datos="modal.datos" :API_URL="`/api/pregunta/${modal.datos.id}`" @cerrarModal="cerrarModal()" @indexRecursoEliminado="indexRecursoEliminado"></modal-eliminar>
	</div>
</template>

<script>
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
