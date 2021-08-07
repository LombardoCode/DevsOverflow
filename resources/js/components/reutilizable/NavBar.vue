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
						<div id="campana-notificacion" class="relative text-xl px-2 py-3 mr-7 text-gray-500 cursor-pointer">
							<div class="relative" @click="notificaciones.mostrar = !notificaciones.mostrar">
								<div id="contador-de-notificaciones" class="absolute text-xs bg-blue-600 text-white font-bold rounded-full" style="padding: 2px 4px; top: -20%; left: 70%;">{{notificaciones.cantidad_no_leida}}</div>
								<font-awesome-icon icon="bell" class="hover:text-blue-800 transition-all duration-100" />
							</div>
							<div id="notificaciones-lista" class="absolute bg-azul-100 w-96 max-h-72 overflow-hidden overflow-y-scroll text-sm text-black border-l-2 border-r-2 border-gray-400" style="right: 0%; top: 53px;" v-if="notificaciones.mostrar">
								<div v-for="(notificacion, index) in notificaciones.datos" :key="index" class="py-3 px-2 hover:bg-blue-300 border-b-2 border-gray-400 transition-all duration-100">
									<a :href="notificacion.url">
										<p class="font-bold">{{notificacion.mensaje}}</p>
										<p>{{notificacion.cuerpo}}</p>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div v-if="usuario.name">{{ usuario.name }}</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBell } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBell)

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
			}
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
