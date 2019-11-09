/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('institucion', require('./components/Institucion.vue').default);
Vue.component('tipo-institucion', require('./components/TipoInstitucion.vue').default);
Vue.component('rama', require('./components/Rama.vue').default);
Vue.component('estado', require('./components/Estado.vue').default);
Vue.component('cargo', require('./components/Cargo.vue').default);
Vue.component('empleado', require('./components/Empleado.vue').default);
Vue.component('ausencia', require('./components/Ausencia.vue').default);
Vue.component('objetivo', require('./components/Objetivo.vue').default);
Vue.component('curso', require('./components/Curso.vue').default);
Vue.component('cuestionario', require('./components/Cuestionario.vue').default);
Vue.component('usuario', require('./components/Usuario.vue').default);
Vue.component('reporte', require('./components/Reporte.vue').default);
Vue.component('tiponomina', require('./components/TipoNomina.vue').default);
Vue.component('nomina', require('./components/Nomina.vue').default);
Vue.component('encuesta', require('./components/Encuesta.vue').default);
Vue.component('evaluacion', require('./components/Evaluacion.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
    	menu:0
    },
});
