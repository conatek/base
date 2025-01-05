import { defineAsyncComponent } from 'vue';

const components = {
    'hello-component': defineAsyncComponent(() => import('./components/Hello.vue')),
    'world-component': defineAsyncComponent(() => import('./components/World.vue')),

    'campus-create': defineAsyncComponent(() => import('./components/campus/CampusCreate.vue')),
    'campus-edit': defineAsyncComponent(() => import('./components/campus/CampusEdit.vue')),

    'company-index': defineAsyncComponent(() => import('./components/company/CompanyIndex.vue')),
    'company-create': defineAsyncComponent(() => import('./components/company/CompanyCreate.vue')),
    'company-show': defineAsyncComponent(() => import('./components/company/CompanyShow.vue')),
    'company-detail': defineAsyncComponent(() => import('./components/company/CompanyDetail.vue')),
    'company-edit': defineAsyncComponent(() => import('./components/company/CompanyEdit.vue')),
    'company-collaborators': defineAsyncComponent(() => import('./components/company/CompanyCollaborators.vue')),

    'control-panel': defineAsyncComponent(() => import('./components/company/ControlPanel.vue')),
    'sociodemographic-profile': defineAsyncComponent(() => import('./components/company/SociodemographicProfile.vue')),
    'alerts': defineAsyncComponent(() => import('./components/company/Alerts.vue')),
    'indicators': defineAsyncComponent(() => import('./components/company/Indicators.vue')),

    'collaborator-index': defineAsyncComponent(() => import('./components/collaborators/CollaboratorIndex.vue')),
    'collaborator-create': defineAsyncComponent(() => import('./components/collaborators/CollaboratorCreate.vue')),
    'collaborator-show': defineAsyncComponent(() => import('./components/collaborators/CollaboratorShow.vue')),
    'collaborator-edit': defineAsyncComponent(() => import('./components/collaborators/CollaboratorEdit.vue')),
    'collaborator-absence': defineAsyncComponent(() => import('./components/collaborators/CollaboratorAbsence.vue')),
    'collaborator-provision': defineAsyncComponent(() => import('./components/collaborators/CollaboratorProvision.vue')),

    'user-index': defineAsyncComponent(() => import('./components/users/UserIndex.vue')),

    // MODULOS DE ADMINISTRACION
    'wellness-index': defineAsyncComponent(() => import('./components/modules/Wellness.vue')),
    'selection-index': defineAsyncComponent(() => import('./components/modules/Selection.vue')),
    'absence-index': defineAsyncComponent(() => import('./components/modules/Absence.vue')),
    'training-index': defineAsyncComponent(() => import('./components/modules/Training.vue')),
    'performance-index': defineAsyncComponent(() => import('./components/modules/Performance.vue')),
    'provision-index': defineAsyncComponent(() => import('./components/modules/Provision.vue')),

};

// Vue.component('font-awesome-icon', FontAwesomeIcon);

export default components;
