<template>
	<div id="notificaciones-contenedor" class="select-none relative text-xl mr-2 text-gray-500 cursor-pointer px-3 py-3" @click="abrirNotificaciones()">
		<div class="relative">
			<div v-if="notificaciones.cantidad_notificaciones_historicas_no_leidas > 0" id="contador-de-notificaciones" class="absolute text-xs bg-blue-600 text-white font-bold rounded-full" style="padding: 2px 4px; top: -20%; left: 70%;">{{notificaciones.cantidad_notificaciones_historicas_no_leidas}}</div>
			<font-awesome-icon icon="bell" class="hover:text-blue-800 transition-all duration-100" />
		</div>
		<div id="notificaciones-lista" class="fixed lg:absolute bg-white w-full lg:w-contenedor-notificaciones max-h-96 overflow-hidden overflow-y-scroll text-sm text-black border-l-2 border-r-2 border-gray-400 rounded-b-md" v-show="notificaciones.mostrar">
			<div v-if="notificaciones.datos.length > 0">
				<notificacion-en-lista
					v-for="(notificacion, index) in notificaciones.datos" :key="index"
					:notificacion="notificacion"
					:index="index"
					@eliminarNotificacionLocal="eliminarNotificacionLocal"
				>
				</notificacion-en-lista>
			</div>
			<div v-else class="py-3 text-center">
				No hay notificaciones por el momento
			</div>
			<div id="historial-notificaciones" class="text-center bg-blue-600 text-white">
				<a href="/notificaciones" class="inline-block w-full text-md lg:text-xs py-5 lg:py-3 hover:underline">Ver notificaciones</a>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		notificaciones: {}
	},
	methods: {
		abrirNotificaciones() {
			this.notificaciones.mostrar = !this.notificaciones.mostrar;
			this.$emit('cerrarMenuMovil');
		},
		eliminarNotificacionLocal(index_recurso) {
			this.$emit('eliminarNotificacionLocal', index_recurso);
		}
	}
}
</script>

<style scoped>
	#notificaciones-lista {
		right: 0%; top: 60px; z-index: 20;
	}

  @media (min-width: 1024px) {
		#notificaciones-lista {
			right: 0%; top: 55px; z-index: 20;
		}
	}

</style>
