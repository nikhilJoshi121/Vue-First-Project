import Vue from 'vue'; // Vue Core File
import App from './App.vue'; // component
import router from './router'; //Router
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import store from './store';
import Bootstrap from 'bootstrap-vue'; // vue Bootstrtap 
import FlashMessage from '@smartweb/vue-flash-message'; //flash message
import VueChatScroll from 'vue-chat-scroll';

Vue.use(FlashMessage);
Vue.use(VueChatScroll);
Vue.use(Bootstrap);

const app = new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
})