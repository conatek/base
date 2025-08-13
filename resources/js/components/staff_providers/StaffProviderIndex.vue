<template>
    <div>
        <div class="app-page-title">
            <div v-if="selected_provider == null && add_provider == false && edit_provider == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-people-arrows" style="color: rgb(18, 124, 179)"></i>
                    </div>
                    <div>
                        Listado de Proveedores de Personal
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="addProvider()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div>
            </div>
            <div v-else-if="selected_provider == null && add_provider == true && edit_provider == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-puzzle-piece" style="color: rgb(18, 124, 179)"></i>
                    </div>
                    <div>
                        Agregar Proveedor
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_provider != null && add_provider == false && edit_provider == true" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-puzzle-piece" style="color: rgb(18, 124, 179)"></i>
                    </div>
                    <div>
                        Editar Proveedor
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
        </div>
        <div v-if="selected_provider == null && add_provider == false && edit_provider == false" class="main-card mb-3 card">
            <div class="card-body table-responsive">
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
                            <template v-if="props.row && props.row.provider_type_id != 1">
                                <button class="btn btn-sm btn-primary mx-1" @click="editProvider(props.row)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <!-- <button class="btn btn-sm btn-danger mx-1" @click="deleteProvider(props.row.id)"> -->
                                <button class="btn btn-sm btn-danger mx-1" @click="showDeleteAlert(props.row.id)">
                                    <font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar
                                </button>
                            </template>
                            <template v-else>
                                <span class="text-muted">Sin acciones disponibles</span>
                            </template>
                        </span>
                        <span v-else>
                            {{ props.formattedRow[props.column.field] || 'Sin asignar' }}
                        </span>
                    </template>
                </vue-good-table>
            </div>
        </div>
        <div v-else-if="selected_provider == null && add_provider == true && edit_provider == false" class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="storeProvider" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Básica
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="provider_type_id" class="form-label">Tipo de proveedor*</label>
                                                <select v-model="provider_type_id" name="provider_type_id" class="form-control"  id="provider_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Proveedor</option>
                                                    <option v-for="provider_type in filteredProviderTypes" :value="provider_type?.id">{{ provider_type?.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.provider_type_id" class="error text-danger" for="provider_type_id">{{ errors.provider_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="name" class="form-label">Nombre*</label>
                                                <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de proveedor">
                                                <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="province_id" class="form-label">Departamento</label>
                                                <select v-model="province_id" @change="getCities(province_id)" class="form-control" name="province_id" id="province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Departamento</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="city_id" class="form-label">Municipio</label>
                                                <select v-model="city_id" class="form-control" name="city_id" id="city_id">
                                                    <option value="" disabled selected hidden>Seleccionar Municipio</option>
                                                    <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="address" class="form-label">Dirección</label>
                                                <input v-model="address" name="address" id="address" type="text" class="form-control" placeholder="Ingrese dirección">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="website" class="form-label">Sitio web</label>
                                                <input v-model="website" name="website" id="website" type="text" class="form-control" placeholder="Ingrese sitio web">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations" class="form-label">Observaciones</label>
                                                <textarea v-model="observations" name="observations" id="observations" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información De Contacto
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_name" class="form-label">Nombre</label>
                                                <input v-model="contact_name" name="contact_name" id="contact_name" type="text" class="form-control" placeholder="Ingrese nombre de contacto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_email" class="form-label">Email</label>
                                                <input v-model="contact_email" name="contact_email" id="contact_email" type="text" class="form-control" placeholder="Ingrese email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_phone" class="form-label">Teléfono fijo</label>
                                                <input v-model="contact_phone" name="contact_phone" id="contact_phone" type="text" class="form-control" placeholder="Ingrese número fijo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_cellphone" class="form-label">Celular*</label>
                                                <input v-model="contact_cellphone" name="contact_cellphone" id="contact_cellphone" type="text" class="form-control" placeholder="Ingrese número celular">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
        <div v-else-if="selected_provider != null && add_provider == false && edit_provider == true" class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="updateProvider" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Básica
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="provider_type_id" class="form-label">Tipo de proveedor*</label>
                                                <select v-model="provider_type_id" name="provider_type_id" class="form-control"  id="provider_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Proveedor</option>
                                                    <option v-for="provider_type in filteredProviderTypes" :value="provider_type?.id">{{ provider_type?.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.provider_type_id" class="error text-danger" for="provider_type_id">{{ errors.provider_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="name" class="form-label">Nombre*</label>
                                                <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese nombre de proveedor">
                                                <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="province_id" class="form-label">Departamento</label>
                                                <select v-model="province_id" @change="changeProvince(province_id)" class="form-control" name="province_id" id="province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Departamento</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="city_id" class="form-label">Municipio</label>
                                                <select v-model="city_id" class="form-control" name="city_id" id="city_id">
                                                    <option value="" disabled selected hidden>Seleccionar Municipio</option>
                                                    <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="address" class="form-label">Dirección</label>
                                                <input v-model="address" name="address" id="address" type="text" class="form-control" placeholder="Ingrese dirección">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="website" class="form-label">Sitio web</label>
                                                <input v-model="website" name="website" id="website" type="text" class="form-control" placeholder="Ingrese sitio web">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations" class="form-label">Observaciones</label>
                                                <textarea v-model="observations" name="observations" id="observations" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información De Contacto
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_name" class="form-label">Nombre</label>
                                                <input v-model="contact_name" name="contact_name" id="contact_name" type="text" class="form-control" placeholder="Ingrese nombre de contacto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_email" class="form-label">Email</label>
                                                <input v-model="contact_email" name="contact_email" id="contact_email" type="text" class="form-control" placeholder="Ingrese email">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_phone" class="form-label">Teléfono fijo</label>
                                                <input v-model="contact_phone" name="contact_phone" id="contact_phone" type="text" class="form-control" placeholder="Ingrese número fijo">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_cellphone" class="form-label">Celular*</label>
                                                <input v-model="contact_cellphone" name="contact_cellphone" id="contact_cellphone" type="text" class="form-control" placeholder="Ingrese número celular">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

import { VueGoodTable } from 'vue-good-table-next';

export default {
    name: 'StaffProviderIndex',
    components: {
        VueGoodTable,
    },
    props: {
        provider_types: {
            default: null,
        },
        provinces: {
            default: null,
        },
        company_id: {
            default: null,
        },
    },
    data() {
        return {
            providers: [],

            selected_provider: null,
            add_provider: false,
            edit_provider: false,

            provider_type_id: '',
            name: '',
            contact_name: '',
            contact_email: '',
            contact_phone: '',
            contact_cellphone: '',
            province_id: '',
            city_id: '',
            address: '',
            website: '',
            observations: '',

            cities: [],

            columns: [],
            rows: [],

            errors: null,
            message: '',
        };
    },
    mounted() {
        this.getProviders();
    },
    watch: {
        providers: {
            handler() {
                if(this.providers.length > 0) {
                    this.columns = [
                        { label: 'Nombre', field: 'name', sortable: false },
                        { label: 'Tipo', field: 'provider_type.type', sortable: false },
                        { label: 'Contacto', field: 'contact_name', sortable: false },
                        { label: 'Celular', field: 'contact_cellphone', sortable: false },
                        { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'align-right', thClass: 'align-right' },
                    ];
                    this.rows = this.providers;
                }
            },
        },
        province_id: {
            handler(newProvinceId) {
                this.getCities(newProvinceId);
                if(this.selected_provider) {
                    this.city_id = this.selected_provider.city_id || '';
                }
            },
        },
    },
    computed: {
        filteredProviderTypes() {
            return this.provider_types?.filter(pt => pt && pt.id !== 1) || [];
        }
    },
    methods: {
        showDeleteAlert(item) {
            // Ver ejemplos en: https://sweetalert2.github.io/#examples
            this.$swal({
                title: "¿Seguro que deseas eliminar este registro?",
                text: "¡No podrás revertir esto!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3f6ad8",
                cancelButtonColor: "#444054",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                this.deleteProvider(item)
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
        },
        changeProvince(province) {
            this.getCities(province);
            this.city_id = '';
        },
        getCities(province) {
            let dataSend = {
                "province": province,
            }

            axios.post('/get-cities', dataSend).then(
                ({data}) => {
                    this.cities = data.cities
                })
        },
        getMessage(msg) {
            if(msg != '' && msg != null) {
                this.message = msg
            }

            setTimeout(() => {
                this.message = ''

                this.successfully_created_message = false
                this.successfully_updated_message = false
                this.successfully_deleted_message = false
            }, 3000)
        },
        returnToList() {
            this.selected_provider = null
            this.add_provider = false
            this.edit_provider = false

            // providersDatatable();
        },
        getProviders() {
            axios.get(`/providers-data/${this.company_id}`).then(
                (res) => {
                    this.providers = res.data.providers;

                    // providersDatatable();

                    this.errors = null;
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        addProvider() {
            this.selected_provider = null;
            this.add_provider = true;
            this.edit_provider = false;

            this.provider_type_id = '';
            this.name = '';
            this.contact_name = '';
            this.contact_email = '';
            this.contact_phone = '';
            this.contact_cellphone = '';
            this.province_id = '';
            this.city_id = '';
            this.address = '';
            this.website = '';
            this.observations = '';

            this.errors = null;
        },
        editProvider(provider) {
            this.selected_provider = this.providers.find(p => p.id === provider.id);
            this.add_provider = false;
            this.edit_provider = true;

            // console.log(this.selected_provider);

            this.provider_type_id = this.selected_provider.provider_type_id || ''
            this.name = this.selected_provider.name || '';
            this.contact_name = this.selected_provider.contact_name || '';
            this.contact_email = this.selected_provider.contact_email || '';
            this.contact_phone = this.selected_provider.contact_phone || '';
            this.contact_cellphone = this.selected_provider.contact_cellphone || '';
            this.province_id = this.selected_provider.province_id || '';
            // this.city_id = this.selected_provider.city_id || '';
            this.address = this.selected_provider.address || '';
            this.website = this.selected_provider.website || '';
            this.observations = this.selected_provider.observations || '';

            this.errors = null;
        },
        storeProvider() {
            let fd = new FormData()

            fd.append('company_id', this.company_id)
            fd.append('provider_type_id', this.provider_type_id)
            fd.append('name', this.name)
            if (this.contact_name && this.contact_name.trim() !== '') {
                fd.append('contact_name', this.contact_name);
            }
            if (this.contact_email && this.contact_email.trim() !== '') {
                fd.append('contact_email', this.contact_email);
            }
            if (this.contact_phone && this.contact_phone.trim() !== '') {
                fd.append('contact_phone', this.contact_phone);
            }
            if (this.contact_cellphone && this.contact_cellphone.trim() !== '') {
                fd.append('contact_cellphone', this.contact_cellphone);
            }
            if (this.province_id && this.province_id !== '') {
                fd.append('province_id', this.province_id);
            }
            if (this.city_id && this.city_id !== '') {
                fd.append('city_id', this.city_id);
            }
            if (this.address && this.address.trim() !== '') {
                fd.append('address', this.address);
            }
            if (this.website && this.website.trim() !== '') {
                fd.append('website', this.website);
            }
            if (this.observations && this.observations.trim() !== '') {
                fd.append('observations', this.observations);
            }

            axios.post('/staff-providers', fd).then(
                (res) => {
                    this.getMessage(res.data.message)

                    this.getProviders();

                    this.selected_provider = null
                    this.add_provider = false
                    this.edit_provider = false

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        updateProvider() {
            let fd = new FormData()

            fd.append('company_id', this.company_id)
            fd.append('provider_type_id', this.provider_type_id)
            fd.append('name', this.name)
            if (this.contact_name && this.contact_name.trim() !== '') {
                fd.append('contact_name', this.contact_name);
            }
            if (this.contact_email && this.contact_email.trim() !== '') {
                fd.append('contact_email', this.contact_email);
            }
            if (this.contact_phone && this.contact_phone.trim() !== '') {
                fd.append('contact_phone', this.contact_phone);
            }
            if (this.contact_cellphone && this.contact_cellphone.trim() !== '') {
                fd.append('contact_cellphone', this.contact_cellphone);
            }
            if (this.province_id && this.province_id !== '') {
                fd.append('province_id', this.province_id);
            }
            if (this.city_id && this.city_id !== '') {
                fd.append('city_id', this.city_id);
            }
            if (this.address && this.address.trim() !== '') {
                fd.append('address', this.address);
            }
            if (this.website && this.website.trim() !== '') {
                fd.append('website', this.website);
            }
            if (this.observations && this.observations.trim() !== '') {
                fd.append('observations', this.observations);
            }
            fd.append('_method', 'PUT')

            axios.post(`/staff-providers/${this.selected_provider.id}`, fd).then(
                (res) => {
                    this.getMessage(res.data.message)

                    this.getProviders();

                    this.selected_provider = null
                    this.add_provider = false
                    this.edit_provider = false

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        deleteProvider(provider_id) {
            axios.delete(`/staff-providers/${provider_id}`).then(
                (res) => {
                    this.getMessage(res.data.message)

                    this.getProviders();

                    this.selected_provider = null
                    this.add_provider = false
                    this.edit_provider = false

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
    },
};
</script>

<style scoped>
    /* Estilos del componente */
</style>
