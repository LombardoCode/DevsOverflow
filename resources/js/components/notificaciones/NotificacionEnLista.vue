<template>
	<div>
		<div class="flex items-center py-4 px-4 border-b-2 border-gray-400 transition-all duration-100 cursor-pointer select-none" :class="{'bg-blue-200 hover:bg-blue-300' : !notificacion.visto, 'bg-white hover:bg-gray-300': notificacion.visto}">
			<a @click="clicNotificacion(notificacion)" class="flex-1">
				<p class="font-bold">{{notificacion.mensaje}}</p>
				<p>{{notificacion.cuerpo}}</p>
				<p class="text-xs italic">{{notificacion.created_at}}</p>
			</a>
			<div class="p-4 hover:bg-blue-400 rounded-md transition-all duration-200" @click="eliminarNotificacion(notificacion.id)">
				<font-awesome-icon icon="times" class="text-lg text-gray-700" />
			</div>
		</div>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTimes } from '@fortawesome/free-solid-svg-icons'

library.add(faTimes)

export default {
	props: {
		notificacion: [],
		index: Number,
	},
	mounted() {

	},
	methods: {
		clicNotificacion(notificacion) {
			axios.get('/api/notificaciones/leer/' + notificacion.id)
			.then(res => {
				console.log(res.data);
				if (res.data.status) {
					window.location = res.data.url;
				}
			})
			.catch(err => {
				console.log(err);
			})
		},
		async eliminarNotificacion(notificacion_id) {
			console.log("ACCAAA: " + notificacion_id)
			console.log("ACCAAA2: " + this.index)
			this.$emit('eliminarNotificacionLocal', this.index);
			this.$root.$emit('eliminarIndexNotificacionGlobal', notificacion_id);
		}
	}
}
</script>

<style>

</style>
