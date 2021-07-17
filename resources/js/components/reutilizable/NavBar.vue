<template>
	<div class="w-full bg-gray-300 py-3 text-sm">
		<div class="container mx-auto flex justify-between">
			<div id="logo">Logo</div>
			<div id="navbar-items">
				<ul class="flex">
					<li class="mr-3"><a href="/registrarse">Registrarse</a></li>
					<li><a href="/login">Iniciar sesión</a></li>
				</ul>
				<p>{{usuario}}</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		usuario: Object
	}
}
</script>

<style>

</style>