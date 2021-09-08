<template>
	<div>
		<div class="container mx-auto text-sm flex h-screen">
			<div id="pregunta-y-respuestas" class="py-6 px-5 overflow-y-scroll">
				<div id="pregunta" class="mb-14">
					<div id="encabezado-pregunta" class="mb-6">
						<h1 class="text-2xl mb-2">{{pregunta.pregunta}}</h1>
						<p class="text-xs">Formulada por <a :href="`/usuarios/${autor.id}`" class="text-blue-600 hover:underline">{{autor.name}}</a> {{pregunta.fecha_de_creacion}}.</p>
					</div>
					<div id="descripcion" class="flex">
						<div id="votos" class="flex items-center flex-col pr-4">
							<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-blue-600': pregunta.ha_votado == 1}" @click="votarPregunta('positivo')">+</button>
							<span>{{ votacion.num_votos_positivos }}</span>
							<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-red-600': pregunta.ha_votado == -1}" @click="votarPregunta('negativo')">-</button>
							<span>{{ votacion.num_votos_negativos }}</span>
						</div>
						<div id="descripcion-pregunta" class="pl-4">
							<p v-html="pregunta.contenido_html"></p>
						</div>
					</div>
					<div id="categorias" class="mt-4 text-xs">
						<a :href="`/categorias/${categoria}`" v-for="(categoria, index) in pregunta.categorias" :key="index" class="mr-3 bg-azul-100 hover:bg-blue-200 ring-2 ring-blue-500 px-2 py-2 rounded cursor-pointer">
							{{ categoria }}
						</a>
					</div>
				</div>
				<div id="seccion-respuestas">
					<div id="encabezado-respuestas" class="mb-6">
						<h1 class="text-lg mb-3">Tu respuesta</h1>
						<vue-editor v-model="respuesta_contenido_html" :editor-toolbar="editorToolbar" class="bg-white"></vue-editor>
						<div class="flex justify-end mt-3">
							<form @submit.prevent="crearRespuesta()">
								<input type="hidden" name="_token" :value="csrf">
								<input type="submit" class="bg-blue-600 px-5 py-3 text-white rounded-md hover:bg-blue-800 transition-all duration-100 outline-none text-base cursor-pointer" value="Enviar respuesta">
							</form>
						</div>
						<h1 class="text-lg mt-7 mb-3">Respuesta(s)</h1>
						<div id="respuestas">
							<div class="mb-14" v-for="(respuesta, index) in respuestas" :key="index">
								<respuesta
									:respuesta="respuesta"
									:index="index"
									:usuario="usuario"
									@indexRecursoEliminado="indexRecursoEliminado"
								>
								</respuesta>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import ModalInvitacionRegistro from '../modals/ModalInvitacionRegistro.vue';
import Respuesta from './Respuesta.vue';

export default {
	props: {
		usuario: Object,
		csrf: String,
		pregunta_id: {}
	},
	components: {
		ModalInvitacionRegistro,
		Respuesta,
		VueEditor
  },
	data() {
		return {
			pregunta: {},
			respuestas: {},
			autor: {},
			votacion: {
				num_votos_positivos: null,
				num_votos_negativos: null,
				ha_votado: null
			},
			respuesta_contenido_html: null,
			editorToolbar: [
				["bold", "italic", "underline", "strike"],
				[
					{ align: "" },
					{ align: "center" },
					{ align: "right" },
					{ align: "justify" }
				],
				["blockquote", "code-block"],
				[{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
				[{ indent: "-1" }, { indent: "+1" }],
				[{ color: [] }, { background: [] }],
				["link"],
				["clean"] // remove formatting button
			]
		}
	},
	async mounted() {
		this.obtenerDatosPregunta();
	},
	methods: {
		obtenerDatosPregunta() {
			axios.get(`/api/pregunta/${this.pregunta_id}`)
			.then(res => {
				console.log(res.data)
				// Obtenemos la pregunta
				this.pregunta = res.data.pregunta;

				// Obtenemos el autor de la pregunta
				this.autor = res.data.autor;

				// Obtenemos la votación
				this.votacion.num_votos_positivos = res.data.pregunta.votos_positivos;
				this.votacion.num_votos_negativos = res.data.pregunta.votos_negativos;

				// Obtenemos los respuestas
				this.respuestas = res.data.respuestas;
			})
			.catch(err => {
				console.log(err);
			})
		},
		votarPregunta(accion) {
			if (this.usuario.id) {
				let data = new FormData();
				data.append('pregunta_id', this.pregunta.id);
				data.append('accion', accion);
				data.append('tipo', 'pregunta');
				axios.post(`/api/pregunta/votar`, data)
				.then(res => {
					this.pregunta.ha_votado = res.data.ha_votado;
					this.votacion.ha_votado = res.data.ha_votado;
					this.votacion.num_votos_positivos = res.data.votos_positivos;
					this.votacion.num_votos_negativos = res.data.votos_negativos;
				})
				.catch(err => {
					console.log(err);
				})
			} else {
				this.abrirModal();
			}
		},
		crearRespuesta() {
			if (this.usuario.id) {
				let datos = new FormData();
				datos.append('pregunta_id', this.pregunta_id);
				datos.append('contenido_html', this.respuesta_contenido_html);
				axios.post('/api/respuesta', datos)
				.then(res => {
					console.log(res.data);
					this.respuestas.unshift(res.data.respuesta);
				})
				.catch(err => {
					console.log(err);
				})
			} else {
				this.abrirModal();
			}
		},
		indexRecursoEliminado(index_recurso) {
			// Eliminamos localmente la categoría deseada
			this.respuestas.splice(index_recurso, 1);
		}
	}
}
</script>

<style>
	#descripcion-pregunta pre {
		max-width: 400px;
		overflow: auto hidden;
		background-color: #2b2f3f;
		color: #FFFFFF;
		padding: 18px 20px;
		border-radius: 10px;
	}

	@media (min-width: 640px) {
		#descripcion-pregunta pre {
			max-width: 600px;
		}
	}

	@media (min-width: 1024px) {
		#descripcion-pregunta pre {
			max-width: 800px;
		}
	}

  @media (min-width: 1280px) {
		#descripcion-pregunta pre {
			max-width: 1000px;
		}
	}

	@media (min-width: 1535px) {
		#descripcion-pregunta pre {
			max-width: 1200px;
		}
	}
</style>
