<template>
	<div class="respuesta mb-14 px-3 py-5 rounded-md">
		<div class="contenido-respuesta">
			<div class="flex">
				<div id="votos" class="flex items-center flex-col pr-4">
					<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-blue-600': respuesta.ha_votado == 1}" @click="votarRespuesta('positivo', respuesta)">+</button>
					<span>{{ respuesta.votos_positivos }}</span>
					<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-red-600': respuesta.ha_votado == -1}" @click="votarRespuesta('negativo', respuesta)">-</button>
					<span>{{ respuesta.votos_negativos }}</span>
				</div>
				<div id="cuerpo-respuesta" class="w-full pl-4">
					<div class="flex">
						<div v-html="respuesta.contenido_html" class="flex-1 contenido-respuesta"></div>
						<div class="opciones">
							<div
								v-if="usuario.id === respuesta.user_id"
								class="eliminar bg-red-600 hover:bg-red-700 transition-all duration-200 text-white px-3 py-2 rounded-md cursor-pointer"
								@click="abrirModal(respuesta, index)"
							>
								Eliminar
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="autor" class="flex justify-end">
					<div class="flex items-center">
						<img style="width: 50px; height: auto;" src="https://www.uic.mx/posgrados/files/2018/05/default-user.png" alt="">
						<div class="flex flex-col ml-2">
							<span class="text-xs mb-1">
								<a :href="`/usuarios/${respuesta.autor.id}`" class="text-blue-600 hover:underline">{{ respuesta.autor.nombre }}</a>
							</span>
							<span class="text-xs">Respondida el {{ respuesta.created_at }}.</span>
						</div>
					</div>
			</div>
		</div>
		<modal-eliminar v-if="modal.mostrar" :datos="modal.datos" :API_URL="`/api/respuesta/${modal.datos.id}`" @cerrarModal="cerrarModal()" @indexRecursoEliminado="indexRecursoEliminado"></modal-eliminar>
	</div>
</template>

<script>
export default {
	props: {
		respuesta: Object,
		index: Number,
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
		votarRespuesta(accion, respuesta) {
			if (this.usuario.id) {
				let data = new FormData();
				data.append('respuesta_id', respuesta.id);
				data.append('accion', accion);
				data.append('tipo', 'respuesta');
				axios.post(`/api/respuesta/votar`, data)
				.then(res => {
					console.log(res.data);
					respuesta.ha_votado = res.data.ha_votado;
					respuesta.votos_positivos = res.data.votos_positivos;
					respuesta.votos_negativos = res.data.votos_negativos;
				})
				.catch(err => {
					console.log(err);
				})
			} else {
				this.abrirModal();
			}
		},
		abrirModal(datos, index) {
			console.log(datos);
			this.modal = {
				mostrar: true,
				datos: {
					id: datos.id,
					index: this.index,
					titulo: 'Eliminar respuesta',
					cuerpo: '¿Desea eliminar la respuesta?',
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
	.contenido-respuesta > pre {
		background-color: #2b2f3f;
		color: #FFFFFF;
		padding: 12px 14px;
		border-radius: 10px;
		margin: 5px 0px;
	}

	.contenido-respuesta a {
		color: #2563eb;
	}

	.contenido-respuesta a:hover {
		text-decoration: underline;
	}

	.contenido-respuesta > .ql-align-right {
		text-align: right;
	}

	.contenido-respuesta > .ql-align-center {
		text-align: center;
	}
</style>
