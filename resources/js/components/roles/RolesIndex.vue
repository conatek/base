<template>
    <div>
        <button @click="addRole" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar rol</button>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table id="dt_roles" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo de autenticación</th>
                                    <th style="text-align: right;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in roles">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.guard_name }}</td>
                                    <td style="text-align: right;">
                                        <a class="btn btn-sm btn-primary mx-1 my-1" @click="editRole(item, index)" style="width: 80px;"><font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar</a>
                                        <a class="btn btn-sm btn-danger mx-1 my-1" @click="deleteRole(item, index)" style="width: 80px;"><font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="add_role == true && edit_role == false" class="col-md-6">
                        <form @submit.prevent="storeRole" enctype="multipart/form-data">
                            <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                                <div class="card-header">
                                    Agregar Rol
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="name" class="form-label">Nombre*</label>
                                                <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de rol">
                                                <span v-if="errors_roles && errors_roles.name" class="error text-danger" for="name">{{ errors_roles.name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="guard_name_id" class="form-label">Tipo de autenticación*</label>
                                                <select v-model="guard_name_id" class="form-control" name="guard_name_id" id="guard_name_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Autenticación</option>
                                                    <option v-for="guard_name in guard_name_types" :value="guard_name.id">{{ guard_name.name }}</option>
                                                </select>
                                                <span v-if="errors_roles && errors_roles.guard_name_id" class="error text-danger" for="guard_name_id">{{ errors_roles.guard_name_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                    <div v-if="add_role == false && edit_role == true" class="col-md-6">
                        <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                            <div class="card-header">
                                Editar Rol
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="name" class="form-label">Nombre*</label>
                                            <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de rol">
                                            <span v-if="errors_roles && errors_roles.name" class="error text-danger" for="name">{{ errors_roles.name[0] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative mb-3">
                                            <label for="guard_name_id" class="form-label">Tipo de autenticación*</label>
                                            <select v-model="guard_name_id" class="form-control" name="guard_name_id" id="guard_name_id">
                                                <option value="" disabled selected hidden>Seleccionar Tipo Autenticación</option>
                                                <option v-for="guard_name in guard_name_types" :value="guard_name.id">{{ guard_name.name }}</option>
                                            </select>
                                            <span v-if="errors_roles && errors_roles.guard_name_id" class="error text-danger" for="guard_name_id">{{ errors_roles.guard_name_id[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { rolesDatatable } from '../../assets/js/tables.js';

export default {
    name: 'Roles',
    data() {
        return {
            name: '',
            guard_name_id: '',
            roles: [],
            guard_name_types: [
                { id: 'web', name: 'Web' },
                { id: 'api', name: 'API' },
            ],

            add_role: false,
            edit_role: false,
            selected_role: null,

            errors_roles: null,
        };
    },
    mounted() {
        this.getRoles();
    },
    watch: {
        roles: {
            handler() {
                this.$nextTick(() => {
                    rolesDatatable();
                });
            },
        },
    },
    methods: {
        getRoles() {
            axios.get(`/get-roles`).then(
                (res) => {
                    this.roles = res.data.roles

                    this.errors_roles = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_roles = error.response.data.errors
                    }
                })
        },
        addRole() {
            this.resetForm();
            this.add_role = true;
            this.edit_role = false;
        },
        editRole(role) {
            this.add_role = false;
            this.edit_role = true;

            this.name = role.name;
            this.guard_name_id = role.guard_name;

            this.selected_role = role;
        },
        storeRole() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('guard_name', this.guard_name_id);

            axios.post(`/roles`, formData)
                .then((response) => {
                    this.add_role = false;
                    this.edit_role = false;
                    this.resetForm();

                    if ($.fn.dataTable.isDataTable('#dt_roles')) {
                        $('#dt_roles').DataTable().clear().destroy();
                    }

                    this.roles = response.data.roles;

                    // this.getRoles();

                    this.errors_roles = null;
                })
                .catch(error => {
                    this.errors_roles = error.response.data.errors;
                });
        },
        showRole(role) {
            const modal = document.querySelector('.role-detail-modal');
            document.body.appendChild(modal);
            modal.style.zIndex = '1050';

            this.selected_role = role;
        },
        updateRole() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('guard_name_id', this.guard_name_id);
            formData.append('_method', 'PUT');

            axios
                .post(`/roles/${this.selected_role.id}`, formData)
                .then((response) => {
                    this.roles = response.data.roles;

                    this.add_role = false;
                    this.edit_role = false;
                    this.resetForm();

                    this.getRoles();

                    this.errors_roles = null;
                })
                .catch((error) => {
                    this.errors_roles = error.response.data.errors;
                });
        },
        deleteRole(id){
            let url = ''
            axios.delete(`/roles/${id}`).then(
                (res) => {
                    this.roles = res.data.roles;

                    this.add_role = false;
                    this.edit_role = false;
                    this.resetForm();

                    this.getRoles();

                    this.errors_roles = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_roles = error.response.data.errors
                    }
                })
        },
        resetForm() {
            this.name = '';
            this.guard_name_id = '';
            this.errors_roles = null;
        },
    },
};
</script>

<style scoped>
    @import './../../assets/css/custom.css';

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
</style>
