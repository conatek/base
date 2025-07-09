<template>
    <div>
        <button @click="addRole" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar rol</button>

        <div v-if="message" class="mb-3" :class="message_type === 'success' ? 'message-success' : 'message-error'">
            <div class="content d-flex align-items-start p-2">
                <p class="mb-0" style="font-size: 14px;">{{ message }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 col-xl-6">
                <!-- Vista tipo tarjeta en móviles -->
                <div v-if="isMobile">
                    <div
                        v-for="(row, index) in rows"
                        :key="index"
                        class="card mb-3 border shadow-sm"
                    >
                        <div class="card-body">
                            <h5 class="card-title">{{ row.name }}</h5>
                            <p class="card-text">
                                <strong>Tipo de autenticación:</strong> {{ row.guard_name }}
                            </p>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-primary" @click="editRole(row)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <button class="btn btn-sm btn-danger" @click="deleteRole(row.id)">
                                    <font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="table-responsive mb-3">
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :search-options="{
                            enabled: true,
                            placeholder: 'Buscar...',
                            trigger: 'immediate'
                        }"
                        :pagination-options="{
                            enabled: true,
                            perPage: 5,
                            perPageDropdown: [5, 10, 20],
                            dropdownAllowAll: false,
                            mode: 'records',
                            nextLabel: 'Siguiente',
                            prevLabel: 'Anterior',
                            rowsPerPageLabel: 'Filas',
                            ofLabel: 'de',
                            pageLabel: 'Página',
                            allLabel: 'Todo'
                        }"
                        :style-class="'vgt-table bordered condensed'"
                        :no-data-message="'No hay resultados que coincidan'"
                    >
                        <template #table-row="props">
                            <span v-if="props.column.field === 'actions'">
                                <button class="btn btn-sm btn-primary mx-1" @click="editRole(props.row)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <button class="btn btn-sm btn-danger mx-1" @click="deleteRole(props.row.id)">
                                    <font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar
                                </button>
                            </span>
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </div>
            <div v-if="add_role == true && edit_role == false" class="col-md-12 col-xl-6 mb-3">
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
                                        <span v-if="errors_roles && errors_roles.guard_name" class="error text-danger" for="guard_name">{{ errors_roles.guard_name[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div v-if="add_role == false && edit_role == true" class="col-md-6">
                <form @submit.prevent="updateRole" enctype="multipart/form-data">
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

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { rolesDatatable } from '../../assets/js/tables.js';
import { VueGoodTable } from 'vue-good-table-next';

export default {
    name: 'Roles',
    components: {
        VueGoodTable,
    },
    data() {
        return {
            name: '',
            guard_name_id: '',
            roles: [],
            guard_name_types: [
                { id: 'web', name: 'Web' },
                // { id: 'api', name: 'API' },
            ],

            add_role: false,
            edit_role: false,
            selected_role: null,

            message: '',
            message_type: '',
            errors_roles: null,

            columns: [],
            rows: [],

            mobile: window.innerWidth <= 768,
        };
    },
    mounted() {
        this.getRoles();
        window.addEventListener('resize', this.checkMobile);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkMobile);
    },
    watch: {
        roles: {
            handler() {
                this.$nextTick(() => {
                    rolesDatatable();
                });

                if(this.roles.length > 0) {
                    this.columns = [
                        { label: 'Nombre', field: 'name', sortable: false },
                        { label: 'Tipo de autenticación', field: 'guard_name', sortable: false },
                        { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'align-right', thClass: 'align-right' },
                    ];
                    this.rows = this.roles;
                }
            },
        },
    },
    computed: {
        isMobile() {
            return this.mobile;
        }
    },
    methods: {
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
        checkMobile() {
            this.mobile = window.innerWidth <= 768;
        },
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

                    this.roles = response.data.roles;

                    this.getMessage(response.data.success, response.data.message);

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
            formData.append('guard_name', this.guard_name_id);
            formData.append('_method', 'PUT');

            axios
                .post(`/roles/${this.selected_role.id}`, formData)
                .then((response) => {
                    this.roles = response.data.roles;

                    this.add_role = false;
                    this.edit_role = false;
                    this.resetForm();

                    this.roles = response.data.roles;

                    this.getMessage(response.data.success, response.data.message);

                    this.errors_roles = null;
                })
                .catch((error) => {
                    this.errors_roles = error.response.data.errors;
                });
        },
        deleteRole(id){
            let url = ''
            axios.delete(`/roles/${id}`).then(
                (response) => {
                    this.add_role = false;
                    this.edit_role = false;
                    this.resetForm();

                    this.roles = response.data.roles;

                    this.getMessage(response.data.success, response.data.message)

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

<style>
    @import './../../assets/css/custom.css';
    @import './../../assets/css/custom-vue-good-tables.css';
    @import './../../assets/css/message.css';
</style>
