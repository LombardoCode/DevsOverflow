<template>
	<div class="w-full altura-nabvar bg-gray-300 text-sm fixed flex items-center">
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
								<div v-if="notificaciones.cantidad_no_leida > 0" id="contador-de-notificaciones" class="absolute text-xs bg-blue-600 text-white font-bold rounded-full" style="padding: 2px 4px; top: -20%; left: 70%;">{{notificaciones.cantidad_no_leida}}</div>
								<font-awesome-icon icon="bell" class="hover:text-blue-800 transition-all duration-100" />
							</div>
							<div id="notificaciones-lista" class="absolute bg-white w-96 max-h-72 overflow-hidden overflow-y-scroll text-sm text-black border-l-2 border-r-2 border-gray-400" style="right: 0%; top: 53px;" v-if="notificaciones.mostrar">
								<div v-for="(notificacion, index) in notificaciones.datos" :key="index" class="py-3 px-2 border-b-2 border-gray-400 transition-all duration-100" :class="{'bg-blue-200 hover:bg-blue-300' : !notificacion.visto, 'bg-white hover:bg-gray-300': notificacion.visto}">
									<a @click="clicNotificacion(notificacion)">
										<p class="font-bold">{{notificacion.mensaje}}</p>
										<p>{{notificacion.cuerpo}}</p>
									</a>
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

library.add(faBell, faCaretDown)

Vue.component('font-awesome-icon', FontAwesomeIcon)
import VueInput from './VueInput.vue';
export default {
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
	},
	data() {
		return {
			busqueda_input: '',
			notificaciones: {
				datos: [],
				cantidad_no_leida: 0,
				mostrar: false
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

				for (let i = 0; i < this.notificaciones.datos.length; i++) {
					let notificacion = this.notificaciones.datos[i];

					if (!notificacion.visto) {
						this.notificaciones.cantidad_no_leida++;
					}
				}

				console.log(this.notificaciones);
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
