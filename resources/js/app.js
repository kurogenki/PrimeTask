import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Layout from '@/Pages/Layout.vue';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: name => {
      const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
      let page = pages[`./Pages/${name}.vue`]
      page.default.layout = page.default.layout || Layout
      return page
    },
    setup({ el, App, props, plugin }) {
      const app = createApp({ render: () => h(App, props) });
      app.config.globalProperties.route = route;
      app.use(plugin);
      app.mount(el);
    },
  })

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
//     setup({ el, App, props, plugin }) {
//         return createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });
