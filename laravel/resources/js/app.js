
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('dashboard-component', require('./components/Dashboard.vue'));

Vue.component('timeline-dashboard', require('./components/Timeline/TimelineDashboard.vue'));
Vue.component('timeline-picker', require('./components/Timeline/TimelinePicker.vue'));

Vue.component('select-widget', require('./components/SelectWidget.vue'));
Vue.component('filterable-list', require('./components/FilterableList.vue'));

const app = new Vue({
    el: '#app'
});
