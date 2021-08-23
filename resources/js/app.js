/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
* The following block of code may be used to automatically register your
* Vue components. It will recursively scan this directory for the Vue
* components and automatically register them with their "basename".
*
* Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
*/

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)

/* Elementos reutilizables */
// Elementos HTML de la página
Vue.component('vue-input', require('./components/elementos_html/VueInput.vue').default);
Vue.component('vue-textarea', require('./components/elementos_html/VueTextarea.vue').default);
Vue.component('vue-input-submit', require('./components/elementos_html/VueInputSubmit.vue').default);
Vue.component('vue-anchor-button', require('./components/elementos_html/VueAnchorButton.vue').default);

// Elementos del layout de la página
Vue.component('navbar', require('./components/elementos_layout/NavBar.vue').default);
Vue.component('vue-footer', require('./components/elementos_layout/VueFooter.vue').default);
Vue.component('sidebar-izquierda', require('./components/elementos_layout/SidebarIzquierda.vue').default);

// Elementos relacionados a las preguntas
Vue.component('listado-preguntas', require('./components/preguntas/ListadoPreguntas.vue').default);
Vue.component('mostrar-pregunta', require('./components/preguntas/MostrarPregunta.vue').default);
Vue.component('pregunta-en-lista', require('./components/preguntas/PreguntaEnLista.vue').default);
Vue.component('crear-pregunta', require('./components/auth/CrearPregunta.vue').default);
Vue.component('paginacion', require('./components/preguntas/Paginacion.vue').default);

// Modals
Vue.component('modal-eliminar', require('./components/modals/ModalEliminar.vue').default);
Vue.component('modal-invitacion-registro', require('./components/modals/ModalInvitacionRegistro').default);

// Usuarios
Vue.component('mostrar-usuarios', require('./components/usuarios/MostrarUsuarios.vue').default);

// Categorías
Vue.component('mostrar-categorias', require('./components/categorias/MostrarCategorias.vue').default);

// Notificaciones
Vue.component('listado-notificaciones', require('./components/notificaciones/ListadoNotificaciones.vue').default);
Vue.component('notificacion-en-lista', require('./components/notificaciones/NotificacionEnLista.vue').default);



/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

const app = new Vue({
	el: '#app',
});
