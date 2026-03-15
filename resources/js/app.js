import './bootstrap';

import { createApp } from 'vue';
import router from '@/router';
import auth from '@/store/auth';
import App from '@/components/App.vue';
import components from './components';

import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue-good-table-next/dist/vue-good-table-next.css';

import './assets/css/collaborator_show.css';
import './assets/css/company_detail.css';
import './assets/css/company_show.css';
import './assets/css/custom-permissions-table.css';
import './assets/css/custom-vue-good-tables.css';
import './assets/css/custom.css';
import './assets/css/message.css';

const app = createApp(App);

// Registrar todos los componentes globales
Object.entries(components).forEach(([name, component]) => {
    app.component(name, component);
});

// $can() lee del store reactivo — funciona de forma reactiva
app.config.globalProperties.$can = function (permissionName) {
    return auth.permissions.includes(permissionName);
};

app.use(router);
app.use(VueSweetalert2);

library.add(fas);
library.add(far);
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
