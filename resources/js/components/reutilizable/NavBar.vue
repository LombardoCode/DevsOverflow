<template>
	<div class="w-full bg-gray-300 py-3 text-sm">
		<div class="container mx-auto flex justify-between items-center">
			<div id="logo">Logo</div>
			<div id="barra-de-busqueda" class="flex-1 mx-28">
				<form :action="`/busqueda/${busqueda_input}`">
					<vue-input placeholder="Buscar..." v-model="busqueda_input"></vue-input>
				</form>
			</div>
			<div id="navbar-items">
				<ul class="flex" v-if="!nombre_usuario">
					<li class="mr-3"><a href="/registrarse">Registrarse</a></li>
					<li><a href="/login">Iniciar sesión</a></li>
				</ul>
				<div else>
					<div>{{ nombre_usuario }}</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import VueInput from './VueInput.vue';
export default {
	props: {
		nombre_usuario: String
	},
	components: {
		VueInput
	},
	data() {
		return {
			busqueda_input: ''
		}
	},
	methods: {
		realizarBusqueda() {
			console.log(this.busqueda_input)
		}
	}
}
</script>

<style>

</style>
