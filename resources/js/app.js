require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)


Vue.use(VueRouter);
let routes = [
    { path: '/', component: require('./components/HomeComponent.vue').default},
]
  
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.component(
    'home-view',
    require('./components/HomeComponent.vue').default
);

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
