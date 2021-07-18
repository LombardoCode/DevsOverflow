<template>
	<div>
		<div class="container mx-auto">
			<h1 class="font-bold text-2xl mt-8 mb-6">Realiza una pregunta a la comunidad</h1>
			<div class="bg-gray-300 flex-1 mt-3 rounded px-3 pt-4 pb-1">
				<form action="/api/pregunta" method="POST">
					<input type="hidden" name="_token" :value="csrf">
					<input type="hidden" name="contenido_html" :value="contenido_html">
					<div class="flex flex-col mb-3">
						<label for="titulo" class="mb-1 font-bold text-lg">Título</label>
						<p class="mb-2">Sé específico e imagina que haces tú pregunta a otra persona.</p>
						<vue-input type="text" name="titulo" placeholder='Por ejemplo, "Laravel me muestra un error 404 en una ruta aún cuando está definida como endpoint."'></vue-input>
					</div>
					<div class="flex flex-col mb-3">
						<label for="contenido_html" class="mb-1 font-bold text-lg">Cuerpo</label>
						<p class="mb-2">Incluye toda la información que necesitaría una persona para resolver tu pregunta.</p>
						<vue-editor class="bg-white" v-model="contenido_html"></vue-editor>
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
		csrf: String
	},
	components: {
    VueEditor
  },
	data() {
		return {
			contenido_html: ''
		}
	}
}
</script>

<style>

</style>
