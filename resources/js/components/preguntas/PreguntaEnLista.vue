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
				<a :href="`/pregunta/${identificador_pregunta}`" class="text-blue-700 text-base">{{ titulo_pregunta }}</a>
				<p>{{ descripcion_pregunta }}</p>
			</div>
			<div id="secciones-y-creador" class="grid grid-cols-2 mt-2">
				<div id="secciones" class="flex">
					<div class="text-sm px-3 mr-2 bg-blue-200 text-blue-600 rounded flex justify-center items-center"><a href="/categoria/vue">vue.js</a></div>
				</div>
				<div id="creador" class="flex justify-end items-center">
					<span class="text-xs text-right">Formulada el {{ fecha_de_creacion }} por {{ autor }}.</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		cantidad_votos: [String, Number],
		cantidad_respuestas: [String, Number],
		identificador_pregunta: String,
		titulo_pregunta: String,
		descripcion_pregunta: String,
		fecha_de_creacion: String,
		autor: String
	}
}
</script>

<style>

</style>
