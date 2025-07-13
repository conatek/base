import { defineAsyncComponent } from 'vue';

const components = {
    'home': defineAsyncComponent(() => import('./components/home/Home.vue')),
    'master-home': defineAsyncComponent(() => import('./components/home/MasterHome.vue')),
    'super-home': defineAsyncComponent(() => import('./components/home/SuperHome.vue')),
    'admin-home': defineAsyncComponent(() => import('./components/home/AdminHome.vue')),
    'default-home': defineAsyncComponent(() => import('./components/home/DefaultHome.vue')),

    'sociodemographic-profile': defineAsyncComponent(() => import('./components/company/SociodemographicProfile.vue')),
    'alerts': defineAsyncComponent(() => import('./components/company/Alerts.vue')),
    'indicators': defineAsyncComponent(() => import('./components/company/Indicators.vue')),

    'access-manager': defineAsyncComponent(() => import('./components/access/AccessManager.vue')),
    'roles-index': defineAsyncComponent(() => import('./components/roles/RolesIndex.vue')),
    'permissions-index': defineAsyncComponent(() => import('./components/permissions/PermissionsIndex.vue')),
    'modules-index': defineAsyncComponent(() => import('./components/modules/ModulesIndex.vue')),

    'campus-create': defineAsyncComponent(() => import('./components/campus/CampusCreate.vue')),
    'campus-edit': defineAsyncComponent(() => import('./components/campus/CampusEdit.vue')),

    'company-index': defineAsyncComponent(() => import('./components/company/CompanyIndex.vue')),
    'company-create': defineAsyncComponent(() => import('./components/company/CompanyCreate.vue')),
    'company-show': defineAsyncComponent(() => import('./components/company/CompanyShow.vue')),
    'company-detail': defineAsyncComponent(() => import('./components/company/CompanyDetail.vue')),
    'company-edit': defineAsyncComponent(() => import('./components/company/CompanyEdit.vue')),
    'company-collaborators': defineAsyncComponent(() => import('./components/company/CompanyCollaborators.vue')),

    'collaborator-index': defineAsyncComponent(() => import('./components/collaborators/CollaboratorIndex.vue')),
    'collaborator-create': defineAsyncComponent(() => import('./components/collaborators/CollaboratorCreate.vue')),
    'collaborator-show': defineAsyncComponent(() => import('./components/collaborators/CollaboratorShow.vue')),
    'collaborator-edit': defineAsyncComponent(() => import('./components/collaborators/CollaboratorEdit.vue')),
    'collaborator-absence': defineAsyncComponent(() => import('./components/collaborators/CollaboratorAbsence.vue')),
    'collaborator-provision': defineAsyncComponent(() => import('./components/collaborators/CollaboratorProvision.vue')),

    'user-index': defineAsyncComponent(() => import('./components/users/UserIndex.vue')),

    // MODULOS DE ADMINISTRACION - SELECCION
    'selection-index': defineAsyncComponent(() => import('./components/modules/selection/Selection.vue')),
    'collaborator-requisition-create': defineAsyncComponent(() => import('./components/modules/selection/CollaboratorRequisitionCreate.vue')),

    // MODULOS DE ADMINISTRACION - AUSENTISMO
    'absence-index': defineAsyncComponent(() => import('./components/modules/Absence.vue')),

    // MODULOS DE ADMINISTRACION - DOTACION
    'provision-index': defineAsyncComponent(() => import('./components/modules/Provision.vue')),

    // MODULOS DE ADMINISTRACION - PLANES DE FORMACION
    'training-index': defineAsyncComponent(() => import('./components/modules/Training.vue')),

    // MODULOS DE ADMINISTRACION - EVALUACION DE DESEMPEÑO
    'performance-index': defineAsyncComponent(() => import('./components/modules/Performance.vue')),

    // MODULOS DE ADMINISTRACION - BIENESTAR
    'wellness-index': defineAsyncComponent(() => import('./components/modules/Wellness.vue')),

    // HERRAMIENTAS - GESTTION DE HORAS EXTRAS
    'overtime-index': defineAsyncComponent(() => import('./components/tools/Overtime.vue')),

    // HERRAMIENTAS - GESTION DE INVENTARIO
    'inventory-index': defineAsyncComponent(() => import('./components/tools/Inventory.vue')),

    // HERRAMIENTAS - GESTION DE TARJETAS
    'cards-index': defineAsyncComponent(() => import('./components/tools/Cards.vue')),

};

// Vue.component('font-awesome-icon', FontAwesomeIcon);

export default components;
