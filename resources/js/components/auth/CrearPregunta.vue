<template>
	<div>
		<div class="container mx-auto">
			<h1 class="font-bold text-2xl mb-6">Realiza una pregunta a la comunidad</h1>
			<div class="bg-gray-300 flex-1 mt-3 rounded px-3 pt-4 pb-1">
				<form v-if="pregunta != null" @submit.prevent="submitFormulario()">
					<div class="flex flex-col mb-3">
						<label for="titulo" class="mb-1 font-bold text-lg">Título</label>
						<p class="mb-2">Sé específico e imagina que haces tú pregunta a otra persona.</p>
						<vue-input  type="text" name="titulo" placeholder='Por ejemplo, "Laravel me muestra un error 404 en una ruta aún cuando está definida como endpoint."' v-model="formulario.titulo"></vue-input>
					</div>
					<div class="flex flex-col mb-3">
						<label for="contenido_html" class="mb-1 font-bold text-lg">Cuerpo</label>
						<p class="mb-2">Incluye toda la información que necesitaría una persona para resolver tu pregunta.</p>
						<vue-editor class="bg-white" v-model="formulario.contenido_html"></vue-editor>
					</div>
					<div class="flex flex-col mb-3">
						<label for="titulo" class="mb-1 font-bold text-lg">Categorías</label>
						<p class="mb-2">Especifica los lenguajes/tecnologías/frameworks en la que se encuentra tu duda.</p>
						<div id="categorias-seleccionadas" class="flex mb-3 text-xs">
							<span v-for="(categoria_seleccionada, index) in categorias.seleccionadas" :key="index" class="mr-3 bg-azul-100 ring-2 ring-blue-500 px-3 py-2 rounded-full">
								{{ categoria_seleccionada.categoria }}
								<span class="px-3 py-2 cursor-pointer" @click="eliminarCategoria(categoria_seleccionada, index)">X</span>
							</span>
						</div>
						<vue-input type="text" name="titulo" placeholder='Escriba una categoría..."' @input="escribiendoCategoria()" v-model="categorias.input" autocomplete="off"></vue-input>
						<div id="busqueda" class="bg-white ring-2 ring-blue-600" v-if="categorias.busqueda" autocomplete="off">
							<div v-for="(categoria, index) in categorias.busqueda" :key="index" class="px-3 py-2 hover:bg-blue-500 hover:text-white cursor-pointer" @click="agregarCategoria(categoria)">
								<p class="font-bold">{{ categoria.categoria }}</p>
								<p class="text-xs italic ">{{ categoria.descripcion }}</p>
							</div>
						</div>
					</div>
					<div class="flex flex-col mb-3">
						<vue-input-submit value="Crear pregunta" type="submit"></vue-input-submit>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
	props: {
		csrf: String,
		pregunta: Object
	},
	components: {
    VueEditor
  },
	data() {
		return {
			formulario: {
				titulo: this.pregunta.pregunta || '',
				contenido_html: this.pregunta.contenido_html || '',
			},
			categorias: {
				input: '',
				busqueda: [],
				seleccionadas: this.pregunta.categorias || []
			}
		}
	},
	methods: {
		submitFormulario() {
			if (this.pregunta.id == null) {
				this.crearPregunta();
			} else {
				this.editarPregunta();
			}
		},
		crearPregunta() {
			let datos = {
				formulario: {
					titulo: this.formulario.titulo,
					contenido_html: this.formulario.contenido_html,
				},
				categorias_seleccionadas: this.categorias.seleccionadas
			}

			axios.post('/api/pregunta', datos)
			.then(res => {
				console.log(res.data);
				if (res.data.status) {
					window.location = '/pregunta/' + res.data.identificador;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		editarPregunta() {
			let datos = {
				formulario: {
					titulo: this.formulario.titulo,
					contenido_html: this.formulario.contenido_html,
				},
				categorias_seleccionadas: this.categorias.seleccionadas
			}

			axios.put(`/api/pregunta/${this.pregunta.id}`, datos)
			.then(res => {
				console.log(res.data);
				if (res.data.status) {
					window.location = '/pregunta/' + res.data.identificador;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		escribiendoCategoria() {
			if (this.categorias.input.length != 0) {
				axios.get(`/api/categoria/${this.categorias.input}`)
				.then(res => {
					console.log(res.data);
					this.categorias.busqueda = res.data.busqueda;
				})
				.catch(err => {
					console.log(err);
				})
			} else {
				this.categorias.busqueda = [];
			}
		},
		agregarCategoria(categoria) {
			// Agregamos la categoría
			this.categorias.seleccionadas.push(categoria);

			// Limpiamos el input y los resultados de búsqueda
			this.categorias.input = '';
			this.categorias.busqueda = [];
		},
		eliminarCategoria(categoria, index) {
			this.categorias.seleccionadas.splice(index, 1);
		}
	}
}
</script>

<style>

</style>
