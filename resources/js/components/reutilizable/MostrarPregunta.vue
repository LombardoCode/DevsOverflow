<template>
	<div>
		<div class="container mx-auto">
			<div id="pregunta">
				<h1 class=" text-2xl mt-8 mb-6">{{pregunta.pregunta}}</h1>
				<p v-html="pregunta.contenido_html"></p>
			</div>
			<div class="bg-gray-300 flex-1 mt-3 rounded px-3 pt-4 pb-1">
				<form action="/api/pregunta" method="POST">
					<input type="hidden" name="_token" :value="csrf">
				</form>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		csrf: String,
		pregunta: {}
	}
}
</script>

<style>

</style>
