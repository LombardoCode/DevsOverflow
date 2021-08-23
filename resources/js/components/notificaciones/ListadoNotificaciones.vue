<template>
	<div class="w-full mb-20">
		<div id="notificaciones">
			<div id="notificaciones-contenedor" class="rounded-md overflow-hidden">
				<notificacion-en-lista
					v-for="(notificacion, index) in notificaciones" :key="index"
					:notificacion="notificacion"
					:index="index"
					@eliminarNotificacionLocal="eliminarNotificacionLocal"
				>
				</notificacion-en-lista>
				<div class="text-center mt-3">
					<button
						v-if="cantidad_notificaciones_historica > notificaciones.length"
						class="w-full bg-blue-600 text-white px-6 py-4 rounded-md font-bold text-md"
						@click="cargarMasNotificaciones()"
					>
						Cargar más notificaciones
					</button>
					<p v-else>Fin de las notificaciones</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			notificaciones: [],
			paginacion: {
				offset: 0,
				limit: 25
			},
			cantidad_notificaciones_historica: null
		}
	},
	mounted() {
		this.realizarBusqueda();
		this.$root.$on('eliminarIndexNotificacionGlobal', id => {
			this.eliminarNotificacionLocalBD_ID(id);
    });
	},
	methods: {
		realizarBusqueda() {
			axios.post('/api/notificaciones/historicas', this.paginacion)
			.then(res => {
				console.log(res.data)
				if (res.data.status) {
					// Obtenemos las notificaciones
					let nuevas_notificaciones = res.data.notificaciones;
					this.notificaciones = [...this.notificaciones, ...nuevas_notificaciones]

					// Obtenemos la cantidad historica de notificaciones del usuario
					this.cantidad_notificaciones_historica = res.data.cantidad_notificaciones_historica;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		cargarMasNotificaciones() {
			// Traemos las siguientes notificaciones
			this.paginacion.offset += this.paginacion.limit;

			// Realizamos la búsqueda
			this.realizarBusqueda();
		},
		eliminarNotificacionLocal(index) {
			// Eliminamos localmente la notificación deseada
			this.notificaciones.splice(index, 1);
		},
		eliminarNotificacionLocalBD_ID(id) {
			let id_a_encontrar = this.notificaciones.map(function(x) {return x.id; }).indexOf(id);
			if (id_a_encontrar != -1) {
				this.eliminarNotificacionLocal(id_a_encontrar);
			}
		},
	}
}
</script>

<style>

</style>
