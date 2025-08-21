import './bootstrap';
import '../css/app.css';
import '../css/icons.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import '@fortawesome/fontawesome-free/css/all.min.css';
import router from './router';
import { createHead } from "@vueuse/head";
import App from "./Compenents/App.vue";

const app = createApp(App);
const head = createHead();
app.use(head);
app.mount("#app");

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(router)
            .mount(el);
    },
});
