<template>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">

                <template v-if="$can('block_company')">
                    <li class="app-sidebar__heading" style="color: white !important;">Gestión de Empresa</li>

                    <li v-if="$can('home_index')" :class="{ 'mm-active': isActive('/home') }">
                        <router-link to="/home" :class="{ 'mm-active': isActive('/home') }">
                            <i class="metismenu-icon fa fa-chart-line"></i>
                            Panel de Control
                        </router-link>
                    </li>

                    <li v-if="$can('companies_index')" :class="{ 'mm-active': startsWith('/companies') }">
                        <router-link to="/companies" :class="{ 'mm-active': startsWith('/companies') }">
                            <i class="metismenu-icon fa fa-building"></i>
                            Empresas
                        </router-link>
                    </li>

                    <li v-if="$can('roles_index')" :class="{ 'mm-active': startsWith('/roles') }">
                        <router-link to="/roles" :class="{ 'mm-active': startsWith('/roles') }">
                            <i class="metismenu-icon fa fa-key"></i>
                            Roles y Permisos
                        </router-link>
                    </li>

                    <li v-if="$can('users_index')" :class="{ 'mm-active': startsWith('/users') }">
                        <router-link to="/users" :class="{ 'mm-active': startsWith('/users') }">
                            <i class="metismenu-icon fa fa-users"></i>
                            Usuarios
                        </router-link>
                    </li>

                    <li v-if="$can('company_index')" :class="{ 'mm-active': isActive('/company') }">
                        <router-link to="/company" :class="{ 'mm-active': isActive('/company') }">
                            <i class="metismenu-icon fa fa-sitemap"></i>
                            Organización
                        </router-link>
                    </li>

                    <li :class="{ 'mm-active': startsWith('/staff-providers') }">
                        <router-link to="/staff-providers" :class="{ 'mm-active': startsWith('/staff-providers') }">
                            <i class="metismenu-icon fa fa-people-arrows"></i>
                            Proveedores
                        </router-link>
                    </li>
                </template>

                <template v-if="$can('block_collaborators')">
                    <li class="app-sidebar__heading" style="color: white !important;">Gestión de Colaboradores</li>

                    <li :class="{ 'mm-active': startsWith('/collaborators') }">
                        <router-link to="/collaborators" :class="{ 'mm-active': startsWith('/collaborators') }">
                            <i class="metismenu-icon fa fa-asterisk"></i>
                            Maestro
                        </router-link>
                    </li>

                    <li :class="{ 'mm-active': modulesOpen }">
                        <a href="#" @click.prevent="toggleModules" :class="{ 'mm-active': modulesOpen }">
                            <i class="metismenu-icon fa fa-cube"></i>
                            Módulos
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul :style="{ display: modulesOpen ? 'block' : 'none' }">
                            <li v-if="$can('selection_index')" :class="{ 'mm-active': isActive('/modules/selection') }">
                                <router-link to="/modules/selection" :class="{ 'mm-active': isActive('/modules/selection') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Procesos de Selección
                                </router-link>
                            </li>
                            <li v-if="$can('absence_index')" :class="{ 'mm-active': isActive('/modules/absence') }">
                                <router-link to="/modules/absence" :class="{ 'mm-active': isActive('/modules/absence') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Ausentismo
                                </router-link>
                            </li>
                            <li v-if="$can('provision_index')" :class="{ 'mm-active': isActive('/modules/provision') }">
                                <router-link to="/modules/provision" :class="{ 'mm-active': isActive('/modules/provision') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Dotación
                                </router-link>
                            </li>
                            <li v-if="$can('training_index')" :class="{ 'mm-active': isActive('/modules/training') }">
                                <router-link to="/modules/training" :class="{ 'mm-active': isActive('/modules/training') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Planes de Formación
                                </router-link>
                            </li>
                            <li v-if="$can('performance_index')" :class="{ 'mm-active': isActive('/modules/performance') }">
                                <router-link to="/modules/performance" :class="{ 'mm-active': isActive('/modules/performance') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Evaluación de Desempeño
                                </router-link>
                            </li>
                            <li v-if="$can('wellness_index')" :class="{ 'mm-active': isActive('/modules/wellness') }">
                                <router-link to="/modules/wellness" :class="{ 'mm-active': isActive('/modules/wellness') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Bienestar
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </template>

                <template v-if="$can('block_self_management')">
                    <li class="app-sidebar__heading" style="color: white !important;">Autogestión</li>

                    <li :class="{ 'mm-active': startsWith('/self-management') }">
                        <router-link to="/self-management/profile" :class="{ 'mm-active': startsWith('/self-management') }">
                            <i class="metismenu-icon fa fa-address-card"></i>
                            Mi Perfil
                        </router-link>
                    </li>

                    <li v-if="$can('self_management_requests')" :class="{ 'mm-active': selfMgmtRequestsOpen }">
                        <a href="#" @click.prevent="toggleSelfMgmtRequests" :class="{ 'mm-active': selfMgmtRequestsOpen }">
                            <i class="metismenu-icon fa fa-hand-point-up"></i>
                            Solicitudes
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul :style="{ display: selfMgmtRequestsOpen ? 'block' : 'none' }">
                            <li>
                                <router-link to="/tools/overtime">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Certificados
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/tools/inventory">
                                    <i class="metismenu-icon"></i>
                                    Vacaciones
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/tools/cards">
                                    <i class="metismenu-icon"></i>
                                    Permisos
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </template>

                <template v-if="$can('block_utilities')">
                    <li class="app-sidebar__heading" style="color: white !important;">Utilidades</li>

                    <li :class="{ 'mm-active': toolsOpen }">
                        <a href="#" @click.prevent="toggleTools" :class="{ 'mm-active': toolsOpen }">
                            <i class="metismenu-icon fa fa-toolbox"></i>
                            Herramientas
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul :style="{ display: toolsOpen ? 'block' : 'none' }">
                            <li :class="{ 'mm-active': isActive('/tools/overtime') }">
                                <router-link to="/tools/overtime" :class="{ 'mm-active': isActive('/tools/overtime') }">
                                    <i class="metismenu-icon fa fa-toolbox"></i>
                                    Control Horas Extras
                                </router-link>
                            </li>
                            <li :class="{ 'mm-active': isActive('/tools/inventory') }">
                                <router-link to="/tools/inventory" :class="{ 'mm-active': isActive('/tools/inventory') }">
                                    <i class="metismenu-icon"></i>
                                    Inventario
                                </router-link>
                            </li>
                            <li :class="{ 'mm-active': isActive('/tools/cards') }">
                                <router-link to="/tools/cards" :class="{ 'mm-active': isActive('/tools/cards') }">
                                    <i class="metismenu-icon"></i>
                                    Tarjetas
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-news-paper"></i>
                            CMS
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li><a href="#"><i class="metismenu-icon"></i>Listado</a></li>
                            <li><a href="#"><i class="metismenu-icon"></i>Agregar</a></li>
                        </ul>
                    </li>
                </template>

            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AppSidebar',

    data() {
        return {
            modulesOpen: false,
            toolsOpen: false,
            selfMgmtRequestsOpen: false,
        };
    },

    computed: {
        currentPath() {
            return this.$route.path;
        },
    },

    watch: {
        currentPath(path) {
            this.modulesOpen = path.startsWith('/modules');
            this.toolsOpen = path.startsWith('/tools');
            this.selfMgmtRequestsOpen = false;
        },
    },

    created() {
        this.modulesOpen = this.currentPath.startsWith('/modules');
        this.toolsOpen = this.currentPath.startsWith('/tools');
    },

    methods: {
        isActive(path) {
            return this.currentPath === path;
        },

        startsWith(prefix) {
            return this.currentPath.startsWith(prefix);
        },

        toggleModules() {
            this.modulesOpen = !this.modulesOpen;
        },

        toggleTools() {
            this.toolsOpen = !this.toolsOpen;
        },

        toggleSelfMgmtRequests() {
            this.selfMgmtRequestsOpen = !this.selfMgmtRequestsOpen;
        },
    },
};
</script>
