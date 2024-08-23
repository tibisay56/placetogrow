import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { i18nVue } from 'laravel-vue-i18n'

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCreditCard } from '@fortawesome/free-regular-svg-icons';
import { faFileLines } from '@fortawesome/free-regular-svg-icons';
import {faGear, faTrash} from '@fortawesome/free-solid-svg-icons';
import { faAddressCard } from '@fortawesome/free-regular-svg-icons';


library.add(faAddressCard, faCreditCard, faFileLines, faGear, faTrash);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18nVue, {
                lang: 'en',
                resolve: lang => {
                    const langs = import.meta.glob('../../lang/*.json', { eager: true });
                    return langs[`../../lang/${lang}.json`].default;
                },
            })
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
