<template>
	<div id="pregunta" class="flex mb-10 w-full">
		<div id="valoraciones" class="flex flex-col mr-4">
			<div class="text-center bg-blue-500 text-white px-3 py-1 rounded-md mb-2">
				<p>{{ cantidad_votos }}</p>
				<p>voto(s)</p>
			</div>
			<div class="text-center bg-green-500 text-white px-3 py-1 rounded-md">
				<p>{{ cantidad_respuestas }}</p>
				<p>respuesta(s)</p>
			</div>
		</div>
		<div class="w-full">
			<div>
				<div class="flex">
					<a :href="`/pregunta/${identificador_pregunta}`" class="flex-1 text-blue-700 text-base">{{ titulo_pregunta }}</a>
					<div v-if="mismo_autor" class="flex">
						<a id="editar" :href="`/pregunta/${identificador_pregunta}/editar`" class="bg-blue-600 text-white px-2 py-2 rounded-md mr-1">
							Editar
						</a>
						<a id="eliminar" :href="`/pregunta/${identificador_pregunta}/eliminar`" class="bg-red-600 text-white px-2 py-2 rounded-md">
							Eliminar
						</a>
					</div>
				</div>
				<p>{{ descripcion_pregunta }}</p>
			</div>
			<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
				<div id="secciones" class="flex">
					<div v-for="(categoria, index) in categorias" :key="index" class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center">
						<a :href="`/categorias/${categoria}`">{{categoria}}</a>
					</div>
				</div>
				<div id="creador" class="flex justify-end items-center">
					<span class="text-xs text-right">Formulada {{ fecha_de_creacion }} por <a :href="`/usuarios/${autor.id}`" class="text-blue-600">{{ autor.nombre }}</a>.</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		mismo_autor: Boolean,
		cantidad_votos: [String, Number],
		cantidad_respuestas: [String, Number],
		identificador_pregunta: String,
		titulo_pregunta: String,
		descripcion_pregunta: String,
		fecha_de_creacion: String,
		categorias: Array,
		autor: Object
	}
}
</script>

<style>

</style>
