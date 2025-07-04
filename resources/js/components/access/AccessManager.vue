<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-key" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Roles y Permisos
                    </div>
                </div>
                <!-- <div class="page-title-actions">
                    <a @click="addModule()" type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Módulo
                    </a>

                    <a @click="addRole()" type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Rol
                    </a>

                    <a @click="addPermission()" type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Permiso
                    </a>
                </div> -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mt-2">
                <button @click="showPermissions()" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: show_permissions }">
                    <i class="fa fa-user-lock btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Permisos
                </button>
            </div>

            <div class="col-md-4 mt-2">
                <button @click="showRoles()" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: show_roles }">
                    <i class="fa fa-universal-access btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Roles
                </button>
            </div>

            <div class="col-md-4 mt-2">
                <button @click="showModules()" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: show_modules }">
                    <i class="fa fa-cubes btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Módulos
                </button>
            </div>
        </div>

        <hr>

        <div v-if="show_permissions && !show_roles && !show_modules">
            <permissions-index></permissions-index>
        </div>

        <div v-else-if="!show_permissions && show_roles && !show_modules">
            <roles-index></roles-index>
        </div>

        <div v-else-if="!show_permissions && !show_roles && show_modules">
            <modules-index></modules-index>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AccessManager',
    data() {
        return {
            show_permissions: true,
            show_modules: false,
            show_roles: false,
        };
    },
    mounted() {
        // Código a ejecutar cuando el componente se monta
    },
    methods: {
        showPermissions() {
            this.show_permissions = true;
            this.show_modules = false;
            this.show_roles = false;
        },
        showModules() {
            this.show_permissions = false;
            this.show_modules = true;
            this.show_roles = false;
        },
        showRoles() {
            this.show_permissions = false;
            this.show_modules = false;
            this.show_roles = true;
        },
    },
};
</script>

<style scoped>
    /* @import './../../assets/css/collaborator_show.css'; */
    @import './../../assets/css/custom.css';

    .td-module {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .data-grid {
        display: grid;
        /* grid-template-columns: 1fr 2fr; */
        grid-template-columns: 30% 70%;
        /* grid-template-rows: repeat(12, auto); */
        gap: 10px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 20px;
        align-items: center;
    }

    .label {
        font-weight: bold;
        text-align: left;
        padding-right: 10px;
    }

    .value {
        text-align: left;
        color: #333;
        background-color: #f9f9f9;
        border: 1px dotted #ccc;
        padding: 5px;
        border-radius: 4px;
    }

    .btn-mh-dark-blue.active {
        background-color: #0dacff;
        color: #fff;
    }
</style>
