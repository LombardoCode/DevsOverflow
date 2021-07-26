<template>
	<div>
		<div class="container mx-auto text-sm flex h-screen" style="padding-top: 52px;">
			<sidebar-izquierda></sidebar-izquierda>
			<div id="pregunta-y-respuestas" class="py-6 px-5">
				<div id="pregunta" class="mb-14">
					<div id="encabezado-pregunta" class="mb-6">
						<h1 class="text-2xl mb-2">{{pregunta.pregunta}}</h1>
						<p class="text-xs"><span class="mr-5">Formulada hace 7 meses</span><span class="mr-5">Activa hace 7 meses</span><span>Vista 97 veces</span></p>
					</div>
					<div id="descripcion" class="flex">
						<div id="votos" class="flex items-center flex-col pr-4">
							<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-blue-600': pregunta.ha_votado == 1}" @click="votarPregunta('positivo')">+</button>
							<span>{{ votacion.num_votos_positivos - votacion.num_votos_negativos }}</span>
							<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-red-600': pregunta.ha_votado == -1}" @click="votarPregunta('negativo')">-</button>
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
						<vue-editor class="bg-white" v-model="respuesta_contenido_html"></vue-editor>
						<div class="flex justify-end mt-3">
							<form @submit.prevent="crearRespuesta()">
								<input type="hidden" name="_token" :value="csrf">
								<input type="submit" class="bg-blue-600 px-5 py-3 text-white rounded-md hover:bg-blue-800 transition-all duration-100 outline-none text-base" value="Enviar respuesta">
							</form>
						</div>
						<h1 class="text-lg mt-7 mb-3">Respuesta(s)</h1>
						<div id="respuestas">
							<div class="respuesta mb-14" v-for="(respuesta, index) in respuestas" :key="index">

								<div class="contenido-respuesta">
									<div class="flex">
										<div id="votos" class="flex items-center flex-col pr-4">
											<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-blue-600': respuesta.ha_votado == 1}" @click="votarRespuesta('positivo', respuesta)">+</button>
											<span>{{ respuesta.votos_positivos }}</span>
											<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-red-600': respuesta.ha_votado == -1}" @click="votarRespuesta('negativo', respuesta)">-</button>
											<span v-if="respuesta.votos_negativos == 0">{{ respuesta.votos_negativos }}</span>
											<span v-else>-{{ respuesta.votos_negativos }}</span>
										</div>
										<div id="descripcion-respuesta" class="pl-4">
											<p v-html="respuesta.contenido_html"></p>
										</div>
									</div>
									<div id="autor" class="flex justify-end">
										<div class="flex flex-col">
											<span class="text-xs">Respondida el {{ respuesta.created_at }}.</span>
											<div class="foto-y-nombreautor flex items-center">
												<img style="width: 50px; height: auto;" src="https://www.uic.mx/posgrados/files/2018/05/default-user.png" alt="">
												<span class="text-xs">{{ respuesta.autor }}</span>
											</div>
										</div>
									</div>
								</div>

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

export default {
	props: {
		csrf: String,
		pregunta_id: {}
	},
	components: {
    VueEditor
  },
	data() {
		return {
			pregunta: {},
			respuestas: {},
			votacion: {
				num_votos_positivos: null,
				num_votos_negativos: null,
				ha_votado: null
			},
			respuesta_contenido_html: null
		}
	},
	mounted() {
		this.obtenerDatosPregunta();
	},
	methods: {
		obtenerDatosPregunta() {
			axios.get(`/api/pregunta/${this.pregunta_id}`)
			.then(res => {
				console.log(res.data)
				// Obtenemos la pregunta
				this.pregunta = res.data.pregunta;

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
		},
		votarRespuesta(accion, respuesta) {
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
		},
		crearRespuesta() {
			let datos = new FormData();
			datos.append('pregunta_id', this.pregunta_id);
			datos.append('contenido_html', this.respuesta_contenido_html);
			axios.post('/api/respuesta', datos)
			.then(res => {
				//console.log(res.data);
				this.respuestas.push(res.data.respuesta);
			})
			.catch(err => {
				console.log(err);
			})
		},
	}
}
</script>

<style>
	#descripcion-pregunta pre {
		background-color: #2b2f3f;
		color: #FFFFFF;
		padding: 18px 20px;
		border-radius: 10px;
	}
</style>
