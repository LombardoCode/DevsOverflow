<template>
	<div class="w-full altura-nabvar bg-gray-300 text-sm fixed flex items-center" v-on-clickaway="cerrarMenus">
		<div class="container mx-auto flex justify-between items-center">
			<div id="logo">
				<a href="/">
					<img src="/imagenes/devsoverflow_logo.png" alt="Logo - DevsOverflow" style="height: 38px;">
				</a>
			</div>
			<div id="barra-de-busqueda" class="flex-1 mx-6">
				<form :action="`/busqueda/${busqueda_input}`">
					<vue-input placeholder="Buscar..." v-model="busqueda_input"></vue-input>
				</form>
			</div>
			<div id="navbar-items">
				<ul class="flex items-center" v-if="!usuario.id">
					<li class="mr-3"><a href="/registrarse">Registrarse</a></li>
					<li><a href="/login">Iniciar sesión</a></li>
				</ul>
				<div v-else-if="usuario.id" class="flex items-center">
					<div id="notificaciones-contenedor" class="select-none">
						<div id="campana-notificacion" class="relative text-xl mr-2 text-gray-500 cursor-pointer px-3 py-3" @click="notificaciones.mostrar = !notificaciones.mostrar">
							<div class="relative">
								<div v-if="notificaciones.cantidad_notificaciones_historicas_no_leidas > 0" id="contador-de-notificaciones" class="absolute text-xs bg-blue-600 text-white font-bold rounded-full" style="padding: 2px 4px; top: -20%; left: 70%;">{{notificaciones.cantidad_notificaciones_historicas_no_leidas}}</div>
								<font-awesome-icon icon="bell" class="hover:text-blue-800 transition-all duration-100" />
							</div>
							<div id="notificaciones-lista" class="absolute bg-white w-96 max-h-96 overflow-hidden overflow-y-scroll text-sm text-black border-l-2 border-r-2 border-gray-400 rounded-b-md" style="right: 0%; top: 53px;" v-show="notificaciones.mostrar">
								<notificacion-en-lista
									v-for="(notificacion, index) in notificaciones.datos" :key="index"
									:notificacion="notificacion"
									:index="index"
									@eliminarNotificacionLocal="eliminarNotificacionLocal"
								>
								</notificacion-en-lista>
								<div id="historial-notificaciones" class="text-center bg-blue-600 text-white">
									<a href="/notificaciones" class="inline-block w-full text-xs py-3 hover:underline">Ver notificaciones</a>
								</div>
							</div>
						</div>
					</div>
					<div id="dropdown-cuenta" class="relative px-2 py-3 mr-7 cursor-pointer select-none">
						<div class="relative flex items-center py-3 px-2 rounded hover:bg-gray-400" @click="dropdown_cuenta.mostrar = !dropdown_cuenta.mostrar">
							<div v-if="usuario.name">{{ usuario.name }}</div>
							<font-awesome-icon icon="caret-down" class="ml-3 text-xl text-gray-700" />
						</div>
						<div id="dropdown-cuenta-items" class="absolute bg-azul-100 w-56 max-h-72 overflow-hidden overflow-y-scroll text-sm text-black border-l-2 border-r-2 border-gray-400" style="right: 0%; top: 61px;" v-if="dropdown_cuenta.mostrar">
							<div class="hover:bg-blue-300 border-b-2 border-gray-400 transition-all duration-100">
								<a href="/ajustes/cuenta" class="py-3 px-2 w-full  inline-block">Mi cuenta</a>
							</div>
							<div class="hover:bg-blue-300 border-b-2 border-gray-400 transition-all duration-100">
								<form action="/api/auth/logout" method="POST">
									<input type="hidden" name="_token" :value="csrf_token">
									<input type="submit" value="Cerrar sesión" class="py-3 px-2 w-full bg-transparent inline-block text-left cursor-pointer">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBell, faCaretDown } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { mixin as clickaway } from 'vue-clickaway';

library.add(faBell, faCaretDown)

Vue.component('font-awesome-icon', FontAwesomeIcon)
import VueInput from '../elementos_html/VueInput.vue';
export default {
	mixins: [ clickaway ],
	props: {
		usuario: Object
	},
	components: {
		VueInput
	},
	mounted() {
		if (this.usuario.id) {
			this.obtenerNotificaciones();
		}
		this.$root.$on('eliminarIndexNotificacionGlobal', id => {
			this.eliminarNotificacionLocalBD_ID(id);
    });
	},
	data() {
		return {
			busqueda_input: '',
			notificaciones: {
				datos: [],
				mostrar: false,
				cantidad_notificaciones_historicas_no_leidas: 0,
			},
			dropdown_cuenta: {
				mostrar: false
			},
			csrf_token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		}
	},
	methods: {
		obtenerNotificaciones() {
			axios.get('/api/notificaciones')
			.then(res => {
				this.notificaciones.datos = res.data.notificaciones;
				this.notificaciones.cantidad_notificaciones_historicas_no_leidas = res.data.cantidad_notificaciones_historicas_no_leidas;
			})
			.catch(err => {
				console.log(err);
			})
		},
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
		eliminarNotificacionLocal(index) {
			// Eliminamos localmente la notificación deseada
			this.notificaciones.datos.splice(index, 1);
		},
		eliminarNotificacionLocalBD_ID(id) {
			let id_a_encontrar = this.notificaciones.datos.map(function(x) {return x.id; }).indexOf(id);
			if (id_a_encontrar != -1) {
				this.eliminarNotificacionLocal(id_a_encontrar);
			}
		},
		cerrarMenus() {
			// Cerramos el menú de las notificaciones y el menú de cuenta
			this.notificaciones.mostrar = false;
			this.dropdown_cuenta.mostrar = false;
		}
	}
}
</script>

<style>
	.altura-nabvar {
		height: 54px;
	}
	::-webkit-scrollbar {
		width: 0px;
		background: transparent;
	}
</style>
