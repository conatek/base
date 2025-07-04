<template>
    <div class="main-card mb-3 card">
        <div class="card-header">
            <h5 class="card-title">Mostrar Permisos</h5>
        </div>
            <!-- <div class="card-body"></div> -->
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
                            <td :colspan="roles.length + 2" class="td-module">{{ module }}</td>
                        </tr>
                        <tr v-for="permission in permissions" :key="permission.id">
                            <td>{{ permission.display_name }}</td>
                            <td v-for="role in roles" :key="role.id" class="form-group clearfix text-center">
                                <div class="icheck-primary d-inline">
                                    <input
                                        type="checkbox"
                                        :id="`permission-${role.id}-${permission.id}`"
                                        :name="`permissions[${role.id}][${permission.id}]`"
                                        :checked="isPermissionAssigned(permission.name, role.name)"
                                        @change="togglePermission(permission.name, role.name)"
                                    />
                                    <label :for="`permission-${role.id}-${permission.id}`"></label>
                                </div>
                            </td>
                            <td class="td-actions" style="text-align: right; vertical-align: middle; padding: 0;">
                                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 0.5rem; margin-right: 0.5rem;">
                                    <a :href="`/permissions/${permission.id}`" class="btn-icon btn btn-sm btn-success">
                                        <i class="fa fa-eye btn-icon-wrapper"></i>Mostrar
                                    </a>
                                    <a :href="`/permissions/${permission.id}/edit`" class="btn-icon btn btn-sm btn-primary">
                                        <i class="fa fa-edit btn-icon-wrapper"></i>Editar
                                    </a>
                                    <form :action="`/permissions/${permission.id}`" method="POST" style="display: inline;">
                                        <button class="btn-icon btn btn-sm btn-danger" type="submit">
                                            <i class="fa fa-trash btn-icon-wrapper"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
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
