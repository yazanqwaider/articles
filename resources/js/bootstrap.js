// import _ from 'lodash';
// window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'


createInertiaApp({
    resolve: (name) => import(`./Pages/${name}.vue`),
    setup({el, App, props, plugin}) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    }
});