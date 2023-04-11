
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//var VueResource = require('vue-resource');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
Vue.component('item-comments', require('./components/ItemComments.vue'));
Vue.component('favorite', require('./components/Favorite.vue'));
Vue.component('item-likes', require('./components/ItemLikes.vue'));
Vue.component('item-delete', require('./components/ItemDelete.vue'));
Vue.component('item-restore', require('./components/ItemRestore.vue'));

//Vue.use(VueResource);

const app = new Vue({
    el: '#app',
    data: window.vitrinza
});