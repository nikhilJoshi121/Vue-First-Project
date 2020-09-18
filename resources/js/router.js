import Vue from 'vue';
import VueRouter from 'vue-router';
import Content from './views/Content.vue';
import Home from './views/Home.vue';
import Categories from './views/Categories.vue';
import ChatComponent from './views/Chat.vue';
import LoginComponent from './views/Login.vue';
import RegisterComponent from './views/Register.vue';
import PasswordComponent from './views/ForgotPasswrd.vue';
import * as auth from './services/auth_services';

Vue.use(VueRouter);

const routes = [

    {
        path: '',
        name: 'home',
        component: Home,
        children: [{
                path: '/',
                name: 'content',
                component: Content
            },
            {
                path: '/category',
                name: 'category',
                component: Categories
            },
            {
                path: '/chat-dashboard',
                component: ChatComponent
            },
            {
                path: '/telescope',
                component: RegisterComponent
            }
        ],
        beforeEnter: (to, from, next) => {
            if (!auth.isLoggedIn()) {
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: '/login',
        component: LoginComponent,
        beforeEnter: (to, from, next) => {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/register',
        component: RegisterComponent,
        beforeEnter: (to, from, next) => {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/forgot',
        component: PasswordComponent
    },

]


const router = new VueRouter({
    mode: 'history', //remove # from url 
    routes,
    linkActiveClass: 'active'
})


export default router;

const app = new Vue({
    router
}).$mount('#app')