<template>
	<div
		class="w-full bg-gray-300 text-sm fixed px-3 py-1 select-none"
		v-on-clickaway="cerrarMenus"
		style="z-index: 1;"
		>
		<div class="container mx-auto">

			<div class="w-full flex flex-wrap justify-between items-center">
				<div class="w-full lg:w-auto flex justify-between items-center lg:mb-0" :class="{'mb-4': menu_movil_desplegado}">
					<div id="logo">
						<a href="/">
							<img src="/imagenes/devsoverflow_logo.png" alt="Logo - DevsOverflow" style="height: 38px;">
						</a>
					</div>
					<div class="flex items-center">
						<notificaciones-contenedor
							class="lg:hidden"
							:notificaciones="notificaciones"
							@cerrarMenuMovil="cerrarMenuMovil"
						>
						</notificaciones-contenedor>
						<div
							id="toggle-movil"
							class="flex justify-center lg:hidden px-3 py-2 rounded-md cursor-pointer text-gray-700 border-2 border-gray-700 hover:text-white hover:bg-gray-700 transition-all duration-200"
							@click="abrirMenuMovil()"
						>
							<font-awesome-icon icon="bars" class="text-xl" />
						</div>
					</div>
				</div>

				<div class="lg:flex items-center w-full flex-1" :class="{'hidden': !menu_movil_desplegado}">
					<div id="barra-de-busqueda" class="flex-1 lg:mx-6">
						<form :action="`/busqueda/${busqueda_input}`">
							<vue-input placeholder="Buscar..." v-model="busqueda_input"></vue-input>
						</form>
					</div>
					<div id="navbar-items">
						<ul class="flex flex-col lg:flex-row items-center mt-5 lg:mt-0 text-lg lg:text-sm" v-if="!usuario.id">
							<li class="w-full lg:w-auto lg:mr-3 text-center lg:text-left bg-blue-600 lg:bg-transparent hover:bg-blue-700 lg:hover:bg-transparent transition-all lg:transition-none duration-100 rounded-md text-white lg:text-gray-700 mb-3 lg:mb-0">
								<a class="inline-block w-full py-3 lg:py-0" href="/registrarse">Registrarse</a>
							</li>
							<li class="w-full lg:w-auto text-center lg:text-left bg-blue-600 lg:bg-transparent hover:bg-blue-700 lg:hover:bg-transparent transition-all lg:transition-none duration-100 rounded-md text-white lg:text-gray-700">
								<a class="inline-block w-full py-3 lg:py-0" href="/login">Iniciar sesión</a>
							</li>
						</ul>
						<div v-else-if="usuario.id" class="flex items-center">
							<notificaciones-contenedor
								class="hidden lg:block"
								:notificaciones="notificaciones"
								@cerrarMenuMovil="cerrarMenuMovil"
							>
							</notificaciones-contenedor>
							<div id="dropdown-cuenta" class="relative lg:px-2 lg:mr-7 cursor-pointer select-none w-full lg:w-auto mt-3 lg:mt-0 mb-2 lg:mb-0 border-2 border-gray-500 lg:border-transparent rounded-md lg:rounded-none">
								<div class="relative flex items-center py-3 px-2 rounded hover:bg-gray-400" @click="dropdown_cuenta.mostrar = !dropdown_cuenta.mostrar">
									<div v-if="usuario.name">{{ usuario.name }}</div>
									<font-awesome-icon icon="caret-down" class="ml-3 text-xl text-gray-700" />
								</div>
								<div id="dropdown-cuenta-items" class="relative lg:absolute lg:bg-azul-100 w-full lg:w-56 max-h-72 overflow-hidden overflow-y-scroll text-sm text-black lg:border-l-2 lg:border-r-2 border-gray-400" v-if="dropdown_cuenta.mostrar">
									<div class="hover:bg-blue-300 lg:border-b-2 lg:border-gray-400 transition-all duration-100">
										<a href="/ajustes/cuenta" class="py-3 px-2 w-full  inline-block">Mi cuenta</a>
									</div>
									<div class="bg-red-600 hover:bg-red-700 text-white lg:border-b-2 lg:border-gray-400 transition-all duration-100">
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



		</div>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBell, faCaretDown, faBars } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { mixin as clickaway } from 'vue-clickaway';

library.add(faBell, faCaretDown, faBars)

Vue.component('font-awesome-icon', FontAwesomeIcon)
import NotificacionesContenedor from './NotificacionesContenedor.vue'
import VueInput from '../elementos_html/VueInput.vue';
export default {
	mixins: [ clickaway ],
	props: {
		usuario: Object
	},
	components: {
		VueInput,
		NotificacionesContenedor
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
			menu_movil_desplegado: false,
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
		},
		cerrarMenuMovil() {
			this.menu_movil_desplegado = false;
		},
		abrirMenuMovil() {
			this.menu_movil_desplegado = !this.menu_movil_desplegado;
			this.notificaciones.mostrar = false;
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
