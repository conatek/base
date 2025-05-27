<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-key" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Matriz de Roles y Permisos
                    </div>
                </div>
                <div class="page-title-actions">
                    <a type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Módulo
                    </a>

                    <a type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Rol
                    </a>

                    <a type="button" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar Permiso
                    </a>
                </div>

                <!-- <div class="page-title-actions">
                    <button @click="addCollaborator()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div> -->
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body table-container">
                <table style="width: 100%;" class="table table-cntk table-hover table-bordered sticky-table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Módulo / Permiso</th>
                            <th v-for="role in roles" :key="role.id" style="text-align: center;">{{ role.name }}</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(permissions, module) in permissionsByModule" :key="module">
                            <tr>
                                <td :colspan="roles.length + 2" style="background: #eee;">
                                    <strong>{{ module }}</strong>
                                </td>
                            </tr>
                            <tr v-for="permission in permissions" :key="permission.id">
                                <td>{{ permission.display_name }}</td>
                                <td v-for="role in roles" :key="role.id" class="text-center">
                                    <input
                                        type="checkbox"
                                        :name="`permissions[${role.id}][${permission.id}]`"
                                        :checked="isPermissionAssigned(permission.name, role.name)"
                                        @change="togglePermission(permission.name, role.name)"
                                    />
                                </td>
                                <td class="td-actions" style="text-align: right;">
                                    <a :href="`/permissions/${permission.id}`" class="mb-2 me-2 btn-icon btn btn-sm btn-success">
                                        <i class="pe-7s-look btn-icon-wrapper"></i>Mostrar
                                    </a>
                                    <a :href="`/permissions/${permission.id}/edit`" class="mb-2 me-2 btn-icon btn btn-sm btn-primary">
                                        <i class="pe-7s-pen btn-icon-wrapper"></i>Editar
                                    </a>
                                    <form :action="`/permissions/${permission.id}`" method="POST" style="display: inline;">
                                        <button class="mb-2 me-2 btn-icon btn btn-sm btn-danger" type="submit">
                                            <i class="pe-7s-trash btn-icon-wrapper"></i>Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Roles',
    data() {
        return {
            permissions: null,
            roles: null,
            rolePermissionsMap: null,
        };
    },
    mounted() {
        this.getRolesAndPermissions();
    },
    computed: {
        permissionsByModule() {
            return this.permissions || {};
        }
    },
    methods: {
        getRolesAndPermissions() {
            axios.get(`/get-roles-and-permissions`).then(
                (res) => {
                    this.permissions = res.data.permissions
                    this.roles = res.data.roles
                    this.rolePermissionsMap = res.data.rolePermissionsMap

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        isPermissionAssigned(permissionName, roleName) {
            return this.rolePermissionsMap[roleName]?.includes(permissionName);
        },
        togglePermission(permissionName, roleName) {
            let fd = new FormData()

            fd.append('permission', permissionName)
            fd.append('role', roleName)

            let url = ''
            axios.post('/toggle-permission', fd).then(
                (res) => {
                    console.log(res.data);

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        console.log(error.response.data.errors)
                        this.errors = error.response.data.errors
                    }
                })
        },
    },
    created() {
        // Código a ejecutar cuando el componente es creado
    }
};
</script>

<style scoped>
    @import './../../assets/css/custom.css';
</style>
