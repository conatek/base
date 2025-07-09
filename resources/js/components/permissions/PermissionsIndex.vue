<template>
    <div id="top-page">
        <button @click="addPermission" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar permiso</button>

        <div v-if="message" class="mb-3" :class="message_type === 'success' ? 'message-success' : 'message-error'">
            <div class="content d-flex align-items-start p-2">
                <p class="mb-0" style="font-size: 14px;">{{ message }}</p>
            </div>
        </div>

        <div class="row">
            <div v-if="add_permission == true && edit_permission == false" class="col-md-12 col-xl-6 mb-3">
                <form @submit.prevent="storePermission" enctype="multipart/form-data">
                    <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                        <div class="card-header">
                            Agregar Permiso
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre*</label>
                                        <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de módulo">
                                        <span v-if="errors_permissions && errors_permissions.name" class="error text-danger" for="name">{{ errors_permissions.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="display_name" class="form-label">Nombre a mostrar*</label>
                                        <input v-model="display_name" name="display_name" id="display_name" type="text" class="form-control" placeholder="Ingrese nombre a mostrar">
                                        <span v-if="errors_permissions && errors_permissions.display_name" class="error text-danger" for="display_name">{{ errors_permissions.display_name[0] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="module_id" class="form-label">Módulo*</label>
                                        <select v-model="module_id" class="form-control" name="module_id" id="module_id">
                                            <option value="" disabled selected hidden>Seleccionar Módulo</option>
                                            <option v-for="module in modules" :value="module.id">{{ module.display_name }}</option>
                                        </select>
                                        <span v-if="errors_permissions && errors_permissions.module_id" class="error text-danger" for="module_id">{{ errors_permissions.module_id[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="guard_name_id" class="form-label">Tipo de autenticación*</label>
                                        <select v-model="guard_name_id" class="form-control" name="guard_name_id" id="guard_name_id">
                                            <option value="" disabled selected hidden>Seleccionar Tipo Autenticación</option>
                                            <option v-for="guard_name in guard_name_types" :value="guard_name.id">{{ guard_name.name }}</option>
                                        </select>
                                        <span v-if="errors_permissions && errors_permissions.guard_name" class="error text-danger" for="guard_name">{{ errors_permissions.guard_name[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div v-if="add_permission == false && edit_permission == true" class="col-md-12 col-xl-6 mb-3">
                <form @submit.prevent="updatePermission" enctype="multipart/form-data">
                    <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                        <div class="card-header">
                            Editar Permiso
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre*</label>
                                        <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de módulo">
                                        <span v-if="errors_permissions && errors_permissions.name" class="error text-danger" for="name">{{ errors_permissions.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="display_name" class="form-label">Nombre a mostrar*</label>
                                        <input v-model="display_name" name="display_name" id="display_name" type="text" class="form-control" placeholder="Ingrese nombre a mostrar">
                                        <span v-if="errors_permissions && errors_permissions.display_name" class="error text-danger" for="display_name">{{ errors_permissions.display_name[0] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="module_id" class="form-label">Módulo*</label>
                                        <select v-model="module_id" class="form-control" name="module_id" id="module_id">
                                            <option value="" disabled selected hidden>Seleccionar Módulo</option>
                                            <option v-for="module in modules" :value="module.id">{{ module.display_name }}</option>
                                        </select>
                                        <span v-if="errors_permissions && errors_permissions.module_id" class="error text-danger" for="module_id">{{ errors_permissions.module_id[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="guard_name_id" class="form-label">Tipo de autenticación*</label>
                                        <select v-model="guard_name_id" class="form-control" name="guard_name_id" id="guard_name_id">
                                            <option value="" disabled selected hidden>Seleccionar Tipo Autenticación</option>
                                            <option v-for="guard_name in guard_name_types" :value="guard_name.id">{{ guard_name.name }}</option>
                                        </select>
                                        <span v-if="errors_permissions && errors_permissions.guard_name" class="error text-danger" for="guard_name">{{ errors_permissions.guard_name[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
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
                                        <a href="#top-page" class="btn btn-sm btn-primary mx-1" @click="editPermission(permission)">
                                            <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                        </a>
                                        <a href="#top-page" class="btn btn-sm btn-danger mx-1" @click="deletePermission(permission.id)">
                                            <font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar
                                        </a>
                                    </div>
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
            name: '',
            display_name: '',
            module_id: '',
            guard_name_id: '',

            permissions: null,
            roles: null,
            rolePermissionsMap: null,
            modules: [],
            guard_name_types: [
                { id: 'web', name: 'Web' },
                // { id: 'api', name: 'API' },
            ],

            add_permission: false,
            edit_permission: false,
            selected_permission: null,

            message: '',
            message_type: '',
            errors_permissions: null,
        };
    },
    mounted() {
        this.getRolesAndPermissions();
        this.getModules();
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
        getModules() {
            axios.get(`/get-modules`).then(
                (res) => {
                    this.modules = res.data.modules

                    this.errors_modules = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_modules = error.response.data.errors
                    }
                })
        },
        getMessage(success, msg) {
            if(msg != '' && msg != null) {
                this.message = msg
                if(success) {
                    this.message_type = 'success'
                } else {
                    this.message_type = 'error'
                }
            }

            setTimeout(() => {
                this.message = ''
                this.message_type = ''
            }, 3000)
        },
        addPermission() {
            this.resetForm();
            this.add_permission = true;
            this.edit_permission = false;
        },
        editPermission(permission) {
            this.add_permission = false;
            this.edit_permission = true;

            this.name = permission.name;
            this.display_name = permission.display_name;
            this.module_id = permission.module_id;
            this.guard_name_id = permission.guard_name;

            this.selected_permission = permission;
        },
        storePermission() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('display_name', this.display_name);
            formData.append('module_id', this.module_id);
            formData.append('guard_name', this.guard_name_id);

            console.log('prueba', formData);

            axios.post(`/permissions`, formData)
                .then((response) => {
                    this.add_permission = false;
                    this.edit_permission = false;
                    this.resetForm();

                    // this.modules = response.data.modules;

                    this.getRolesAndPermissions();

                    this.getMessage(response.data.success, response.data.message);

                    this.errors_permissions = null;
                })
                .catch(error => {
                    this.errors_permissions = error.response.data.errors;
                });
        },
        updatePermission() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('display_name', this.display_name);
            formData.append('module_id', this.module_id);
            formData.append('guard_name', this.guard_name_id);
            formData.append('_method', 'PUT');

            axios
                .post(`/permissions/${this.selected_permission.id}`, formData)
                .then((response) => {
                    this.add_permission = false;
                    this.edit_permission = false;
                    this.resetForm();

                    // this.modules = response.data.modules;

                    this.getRolesAndPermissions();

                    this.getMessage(response.data.success, response.data.message);

                    this.errors_permissions = null;
                })
                .catch((error) => {
                    this.errors_permissions = error.response.data.errors;
                });
        },
        deletePermission(id){
            let url = ''
            axios.delete(`/permissions/${id}`).then(
                (response) => {
                    this.add_permission = false;
                    this.edit_permission = false;
                    this.resetForm();

                    this.getRolesAndPermissions();

                    this.getMessage(response.data.success, response.data.message)

                    this.errors_permissions = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_permissions = error.response.data.errors
                    }
                })
        },
        resetForm() {
            this.name = '';
            this.display_name = '';
            this.module_id = '';
            this.guard_name_id = '';
            this.errors_modules = null;
        },
    },
};
</script>

<style scoped>
    @import './../../assets/css/custom.css';
    @import './../../assets/css/message.css';
    @import './../../assets/css/custom-permissions-table.css';
</style>
