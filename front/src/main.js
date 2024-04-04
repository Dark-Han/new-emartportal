import {createApp} from 'vue'
import App from './App.vue'
import './style.css'
import 'vuetify/styles'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import axios from "axios";
import Login from "./components/auth/Login.vue";
import {createVuetify} from "vuetify";
import {createRouter, createWebHistory} from "vue-router";
import Registration from "./components/auth/Registration.vue";
import MainPage from "./components/Layout.vue";
import Registrations from "./components/Registrations.vue";
import Tools from "./components/Tools.vue";
import ToolsTypes from "./components/ToolsTypes.vue";


const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
    theme: {
        defaultTheme: 'dark'
    }
})

axios.defaults.baseURL = 'http://localhost:8080';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const routes = [
    {path: '/auth/login', component: Login},
    {path: '/auth/registration', component: Registration},
    {
        path: '/', component: MainPage, children:
            [
                {
                    path: "registrations",
                    component: Registrations,
                },
                {
                    path: "tools",
                    component: Tools,
                },
                {
                    path: "tools-types",
                    component: ToolsTypes,
                },
            ]
    },
]

const router = createRouter({history: createWebHistory(), routes})

createApp(App)
    .use(vuetify)
    .use(router)
    .mount('#app')