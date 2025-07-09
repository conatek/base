import './bootstrap';

import {createApp} from 'vue';
import components from '@/components';

import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-good-table-next/dist/vue-good-table-next.css';

const app = createApp({});

app.use(VueSweetalert2);

Object.keys(components).forEach(key => {
    app.component(key, components[key]);
});

library.add(fas);
library.add(far);
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
