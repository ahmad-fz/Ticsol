
require('./bootstrap');

import Vue from 'vue';
import Vuelidate from 'vuelidate';
import { sync } from 'vuex-router-sync';
import { store } from './store/store.js';
import { router } from './router.js';
import App from "./components/App.vue";

/* plugins */
import formFeedback from './plugin/formFeedback-plugin.js';
import queryBuilder from './plugin/queryBuilder-plugin';
import TicsolVue from './plugin/ticsol-vue-plugin';
Vue.use(formFeedback);
Vue.use(queryBuilder);
Vue.use(TicsolVue);
Vue.use(Vuelidate);

sync(store, router);

new Vue({
    el: '#app',
    store,
    router,
    components: { App },
});
