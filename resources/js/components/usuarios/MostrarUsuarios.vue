<template>
	<div id="usuarios" class="text-xs flex-1 px-3 overflow-y-scroll">
		<div class="flex items-center justify-between">
			<h5 class="font-bold text-2xl my-6">Usuarios</h5>
			<div class="flex items-center flex-1 justify-end">
				<vue-input class="max-w-md" v-model="paginacion.query" @input="busquedaEscrita()" placeholder="Buscar un usuario..."></vue-input>
				<div class="flex ring-1 ring-gray-600 rounded ml-3">
					<button class="min-w-max px-3 py-2 border-r-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'todos'}" @click="cambiarFiltro('todos')">Todos</button>
					<button class="min-w-max px-3 py-2 border-gray-600" :class="{'bg-gray-600 text-white': paginacion.filtro == 'nuevos_usuarios'}" @click="cambiarFiltro('nuevos_usuarios')">Nuevos usuarios</button>
				</div>
			</div>
		</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
			<div v-for="(usuario, index) in usuarios" :key="index" class="usuario bg-azul-100 hover:bg-blue-200 px-3 py-2 rounded">
				<a :href="`/usuarios/${usuario.id}`" class="flex items-center">
					<img src="https://www.uic.mx/posgrados/files/2018/05/default-user.png" style="width: 40px;">
					<span class="ml-3">{{usuario.name}}</span>
				</a>
			</div>
		</div>
		<paginacion
			:pagina="paginacion.pagina"
			:itemsMaxPorPag="paginacion.itemsMaxPorPag"
			:totalItems="paginacion.totalItems"
			v-on:datosDesdePaginacion="desdePaginacion">
		</paginacion>
	</div>
</template>

<script>
export default {
	data() {
		return {
			usuarios: [],
			paginacion: {
				query: '',
				filtro: 'todos',
				pagina: 0,
				itemsMaxPorPag: 30,
				totalItems: 0
			}
		}
	},
	mounted() {
		this.obtenerUsuarios();
	},
	methods: {
		obtenerUsuarios() {
			axios.post('/api/usuarios', this.paginacion)
			.then(res => {
				console.log(res.data);
				if (res.data.status) {
					this.usuarios = res.data.usuarios;
					this.paginacion.totalItems = res.data.cantidad_de_usuarios;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		busquedaEscrita() {
			this.paginacion.pagina = 0;
			this.obtenerUsuarios();
		},
		desdePaginacion(datos) {
			this.paginacion.pagina = datos.pagina;
			this.paginacion.itemsMaxPorPag = datos.itemsMaxPorPag;
			this.paginacion.totalItems = datos.totalItems;
			this.obtenerUsuarios();
		},
		cambiarFiltro(filtro) {
			this.paginacion.filtro = filtro;
			this.obtenerUsuarios();
		},
	}
}
</script>

<style>

</style>
