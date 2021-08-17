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

// Elementos reutilizables
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('navbar', require('./components/reutilizable/NavBar.vue').default);
Vue.component('vue-input', require('./components/reutilizable/VueInput.vue').default);
Vue.component('vue-textarea', require('./components/reutilizable/VueTextarea.vue').default);
Vue.component('vue-input-submit', require('./components/reutilizable/VueInputSubmit.vue').default);
Vue.component('vue-anchor-button', require('./components/reutilizable/VueAnchorButton.vue').default);
Vue.component('seccion-preguntas', require('./components/reutilizable/SeccionPreguntas.vue').default);
Vue.component('mostrar-pregunta', require('./components/reutilizable/MostrarPregunta.vue').default);
Vue.component('sidebar-izquierda', require('./components/reutilizable/Sidebars/SidebarIzquierda.vue').default);
Vue.component('sidebar-cuenta', require('./components/reutilizable/Sidebars/SidebarCuenta.vue').default);
Vue.component('paginacion', require('./components/reutilizable/Paginacion.vue').default);
Vue.component('vue-footer', require('./components/reutilizable/VueFooter.vue').default);
Vue.component('modal-eliminar', require('./components/reutilizable/Modals/ModalEliminar.vue').default);


Vue.component('administrar-categorias', require('./components/auth/admin/AdministrarCategorias.vue').default);
Vue.component('crear-pregunta', require('./components/auth/CrearPregunta.vue').default);
Vue.component('mostrar-usuarios', require('./components/usuarios/MostrarUsuarios.vue').default);
Vue.component('mostrar-categorias', require('./components/categorias/MostrarCategorias.vue').default);
Vue.component('mostrar-preguntas-categoria', require('./components/categorias/MostrarPreguntasCategoria.vue').default);
Vue.component('mostrar-preguntas-sin-responder', require('./components/sinresponder/MostrarPreguntasSinResponder.vue').default);






/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
