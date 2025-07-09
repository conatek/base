<template>
    <div>
        <button @click="addModule" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar módulo</button>

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
                                <strong>Nombre a mostrar:</strong> {{ row.display_name }}
                            </p>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-primary" @click="editModule(row)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <button class="btn btn-sm btn-danger" @click="deleteModule(row.id)">
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
                                <button class="btn btn-sm btn-primary mx-1" @click="editModule(props.row)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <button class="btn btn-sm btn-danger mx-1" @click="deleteModule(props.row.id)">
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
            <div v-if="add_module == true && edit_module == false" class="col-md-12 col-xl-6 mb-3">
                <form @submit.prevent="storeModule" enctype="multipart/form-data">
                    <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                        <div class="card-header">
                            Agregar Módulo
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre*</label>
                                        <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de módulo">
                                        <span v-if="errors_modules && errors_modules.name" class="error text-danger" for="name">{{ errors_modules.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="display_name" class="form-label">Nombre a mostrar*</label>
                                        <input v-model="display_name" name="display_name" id="display_name" type="text" class="form-control" placeholder="Ingrese nombre a mostrar">
                                        <span v-if="errors_modules && errors_modules.display_name" class="error text-danger" for="display_name">{{ errors_modules.display_name[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div v-if="add_module == false && edit_module == true" class="col-md-6">
                <form @submit.prevent="updateModule" enctype="multipart/form-data">
                    <div class="card-hover-shadow card-border mb-3 card frame-information-card">
                        <div class="card-header">
                            Editar Módulo
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre*</label>
                                        <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de módulo">
                                        <span v-if="errors_modules && errors_modules.name" class="error text-danger" for="name">{{ errors_modules.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="display_name" class="form-label">Nombre a mostrar*</label>
                                        <input v-model="display_name" name="display_name" id="display_name" type="text" class="form-control" placeholder="Ingrese nombre a mostrar">
                                        <span v-if="errors_modules && errors_modules.display_name" class="error text-danger" for="display_name">{{ errors_modules.display_name[0] }}</span>
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
import { VueGoodTable } from 'vue-good-table-next';

export default {
    name: 'Roles',
    components: {
        VueGoodTable,
    },
    data() {
        return {
            name: '',
            display_name: '',
            modules: [],

            add_module: false,
            edit_module: false,
            selected_module: null,

            message: '',
            message_type: '',
            errors_modules: null,

            columns: [],
            rows: [],

            mobile: window.innerWidth <= 768,
        };
    },
    mounted() {
        this.getModules();
        window.addEventListener('resize', this.checkMobile);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkMobile);
    },
    watch: {
        modules: {
            handler() {
                if(this.modules.length > 0) {
                    this.columns = [
                        { label: 'Nombre', field: 'name', sortable: false },
                        { label: 'Nombre a mostrar', field: 'display_name', sortable: false },
                        { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'align-right', thClass: 'align-right' },
                    ];
                    this.rows = this.modules;
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
        addModule() {
            this.resetForm();
            this.add_module = true;
            this.edit_module = false;
        },
        editModule(module) {
            this.add_module = false;
            this.edit_module = true;

            this.name = module.name;
            this.display_name = module.display_name;

            this.selected_module = module;
        },
        storeModule() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('display_name', this.display_name);

            axios.post(`/modules`, formData)
                .then((response) => {
                    this.add_module = false;
                    this.edit_module = false;
                    this.resetForm();

                    this.modules = response.data.modules;

                    this.getMessage(response.data.success, response.data.message);

                    this.errors_modules = null;
                })
                .catch(error => {
                    this.errors_modules = error.response.data.errors;
                });
        },
        updateModule() {
            const formData = new FormData();

            formData.append('name', this.name);
            formData.append('display_name', this.display_name);
            formData.append('_method', 'PUT');

            axios
                .post(`/modules/${this.selected_module.id}`, formData)
                .then((response) => {
                    this.add_module = false;
                    this.edit_module = false;
                    this.resetForm();

                    this.modules = response.data.modules;

                    this.getMessage(response.data.success, response.data.message);

                    this.errors_modules = null;
                })
                .catch((error) => {
                    this.errors_modules = error.response.data.errors;
                });
        },
        deleteModule(id){
            let url = ''
            axios.delete(`/modules/${id}`).then(
                (response) => {
                    this.add_module = false;
                    this.edit_module = false;
                    this.resetForm();

                    this.modules = response.data.modules;

                    this.getMessage(response.data.success, response.data.message)

                    this.errors_modules = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_modules = error.response.data.errors
                    }
                })
        },
        resetForm() {
            this.name = '';
            this.display_name = '';
            this.errors_modules = null;
        },
    },
};
</script>

<style>
    @import './../../assets/css/custom.css';
    @import './../../assets/css/custom-vue-good-tables.css';
    @import './../../assets/css/message.css';
</style>
