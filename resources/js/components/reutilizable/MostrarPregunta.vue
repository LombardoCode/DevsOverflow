<template>
	<div>
		<div class="container mx-auto text-sm flex h-screen">
			<sidebar-izquierda></sidebar-izquierda>
			<div id="pregunta" class="py-6 px-5">
				<div id="encabezado" class="mb-6">
					<h1 class="text-2xl mb-2">{{pregunta.pregunta}}</h1>
					<p class="text-xs"><span class="mr-5">Formulada hace 7 meses</span><span class="mr-5">Activa hace 7 meses</span><span>Vista 97 veces</span></p>
				</div>
				<div id="descripcion" class="flex">
					<div id="votos" class="flex items-center flex-col pr-4">
						<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-blue-600': votacion.ha_votado == 1}" @click="votarPregunta('positivo')">+</button>
						<span>{{ votacion.num_votos_positivos - votacion.num_votos_negativos }}</span>
						<button class="bg-gray-400 text-white px-4 py-2 rounded" :class="{'bg-red-600': votacion.ha_votado == -1}" @click="votarPregunta('negativo')">-</button>
					</div>
					<div id="descripcion-pregunta" class="pl-4">
						<p v-html="pregunta.contenido_html"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		csrf: String,
		pregunta_id: {}
	},
	data() {
		return {
			pregunta: {},
			votacion: {
				num_votos_positivos: null,
				num_votos_negativos: null,
				ha_votado: null
			},
		}
	},
	mounted() {
		this.obtenerDatosPregunta();
	},
	methods: {
		obtenerDatosPregunta() {
			axios.get(`/api/pregunta/${this.pregunta_id}`)
			.then(res => {
				console.log(res.data);
				this.pregunta = res.data.pregunta;
				this.votacion.num_votos_positivos = res.data.pregunta.votos_positivos;
				this.votacion.num_votos_negativos = res.data.pregunta.votos_negativos;
				this.votacion.ha_votado = res.data.ha_votado;
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
			axios.post(`/api/votar/`, data)
			.then(res => {
				console.log(res.data);
				this.votacion.ha_votado = res.data.ha_votado;
				this.votacion.num_votos_positivos = res.data.votos_positivos;
				this.votacion.num_votos_negativos = res.data.votos_negativos;
				console.log(this.votacion)
			})
			.catch(err => {
				console.log(err);
			})
		}
	}
}
</script>

<style>

</style>
