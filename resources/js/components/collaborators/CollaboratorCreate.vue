<template>
    <div>
        <Teleport to="body">
            <div v-if="is_loading" class="loading-overlay">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Procesando...</span>
                </div>
                <p class="loading-text mt-3">Procesando, por favor espera...</p>
            </div>
        </Teleport>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="storeCollaborator" enctype="multipart/form-data">
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
                                                <label for="image" class="form-label">Foto</label>
                                                <input
                                                    ref="imageInput"
                                                    type="file"
                                                    accept="image/*"
                                                    class="form-control d-none"
                                                    @change="onChangeImage"
                                                >
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectImage">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectImage"
                                                        type="text"
                                                        class="form-control"
                                                        :value="image != '' ? image.name : ''"
                                                        readonly
                                                        placeholder="Sin archivo"
                                                    />
                                                </div>
                                                <div v-if="image_src" class="cropper-container">
                                                    <cropper
                                                        ref="cropperRef"
                                                        :src="image_src"
                                                        :stencil-props="{
                                                            aspectRatio: 1/1
                                                        }"
                                                    />
                                                </div>
                                                <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="staff_provider_id" class="form-label">Proveedor*</label>
                                                <select v-model="staff_provider_id" name="staff_provider_id" class="form-control"  id="staff_provider_id">
                                                    <option value="" disabled selected hidden>Seleccionar Proveedor</option>
                                                    <option v-for="staff_provider in staff_providers" :value="staff_provider.id">{{ staff_provider.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.staff_provider_id" class="error text-danger" for="staff_provider_id">{{ errors.staff_provider_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="name" class="form-label">Nombres*</label>
                                                <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingrese su(s) nombre(s)">
                                                <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="first_surname" class="form-label">Primer apellido*</label>
                                                <input v-model="first_surname" name="first_surname" id="first_surname" type="text" class="form-control" placeholder="Ingrese su primer apellido">
                                                <span v-if="errors && errors.first_surname" class="error text-danger" for="first_surname">{{ errors.first_surname[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="second_surname" class="form-label">Segundo apellido</label>
                                                <input v-model="second_surname" name="second_surname" id="second_surname" type="text" class="form-control" placeholder="Ingrese su segundo apellido">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="sex_type_id" class="form-label">Sexo*</label>
                                                <select v-model="sex_type_id" class="form-control" name="sex_type_id" id="sex_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Sexo</option>
                                                    <option v-for="sex in sex_types" :value="sex.id">{{ sex.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.sex_type_id" class="error text-danger" for="sex_type_id">{{ errors.sex_type_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="document_type_id" class="form-label">Tipo de documento*</label>
                                                <select v-model="document_type_id" name="document_type_id" class="form-control"  id="document_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Documento</option>
                                                    <option v-for="document_type in document_types" :value="document_type.id">{{ document_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.document_type_id" class="error text-danger" for="document_type_id">{{ errors.document_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="document_number" class="form-label">Documento*</label>
                                                <input v-model="document_number" name="document_number" id="document_number" type="text" class="form-control" placeholder="Ingrese número documento">
                                                <span v-if="errors && errors.document_number" class="error text-danger" for="document_number">{{ errors.document_number[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="document_province_id" class="form-label">Dpto De Expedición*</label>
                                                <!-- <select v-model="document_province_id" @change="getCities(document_province_id, 'document')" class="form-control" name="province" id="document_province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select> -->
                                                <select 
                                                    v-model="document_province_id" 
                                                    @change="changeProvince(document_province_id, 'document')" 
                                                    class="form-control" 
                                                    name="province" 
                                                    id="document_province_id"
                                                >
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.document_province_id" class="error text-danger" for="document_province_id">{{ errors.document_province_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="document_city_id" class="form-label">Municipio de Expedición*</label>
                                                <select v-model="document_city_id" class="form-control" name="document_city_id" id="document_city_id">
                                                    <!-- <option value="" :selected="cities === []" disabled selected hidden>Seleccionar Municipio</option> -->
                                                    <option value="" disabled selected hidden>Seleccionar Municipio</option>
                                                    <option v-for="city in document_cities" :value="city.id">{{ city.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.document_city_id" class="error text-danger" for="document_city_id">{{ errors.document_city_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="expedition_date" class="form-label">Fecha de Expedición*</label>
                                                <input v-model="expedition_date" name="expedition_date" id="expedition_date" type="date" class="form-control" placeholder="Ingrese fecha expedición documento">
                                                <span v-if="errors && errors.expedition_date" class="error text-danger" for="expedition_date">{{ errors.expedition_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="rh_type_id" class="form-label">RH*</label>
                                                <select v-model="rh_type_id" class="form-control" name="rh_type_id" id="rh_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar RH</option>
                                                    <option v-for="rh in rh_types" :value="rh.id">{{ rh.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.rh_type_id" class="error text-danger" for="rh_type_id">{{ errors.rh_type_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="checkbox_is_foreigner" v-model="is_foreigner">
                                                    <label for="checkbox_is_foreigner">Es extranjero</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="birth_province_id" class="form-label">Dpto De Nacimiento*</label>
                                                <!-- <select
                                                    v-model="birth_province_id"
                                                    :disabled="is_foreigner"
                                                    @change="getCities(birth_province_id, 'birth')"
                                                    class="form-control"
                                                    name="birth_province_id"
                                                    id="birth_province_id"
                                                >
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select> -->
                                                <select
                                                    v-model="birth_province_id"
                                                    :disabled="is_foreigner"
                                                    @change="changeProvince(birth_province_id, 'birth')"
                                                    class="form-control"
                                                    name="birth_province_id"
                                                    id="birth_province_id"
                                                >
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>

                                                <span v-if="errors && errors.birth_province_id" class="error text-danger">{{ errors.birth_province_id[0] }}</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="birth_city_id" class="form-label">Municipio de Nacimiento*</label>

                                                <select
                                                    v-model="birth_city_id"
                                                    :disabled="is_foreigner"
                                                    class="form-control"
                                                    name="birth_city_id"
                                                    id="birth_city_id"
                                                >
                                                    <option value="" disabled selected hidden>Seleccionar Municipio</option>
                                                    <option v-for="city in birth_cities" :value="city.id">{{ city.name }}</option>
                                                </select>

                                                <span v-if="errors && errors.birth_city_id" class="error text-danger">{{ errors.birth_city_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="birth_date" class="form-label">Fecha de Nacimiento*</label>
                                                <input v-model="birth_date" name="birth_date" id="birth_date" type="date" class="form-control">
                                                <span v-if="errors && errors.birth_date" class="error text-danger" for="birth_date">{{ errors.birth_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="civil_status_type_id" class="form-label">Estado Civil*</label>
                                                <select v-model="civil_status_type_id" class="form-control" name="civil_status_type_id" id="civil_status_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Estado Civil</option>
                                                    <option v-for="civil_status in civil_status_types" :value="civil_status.id">{{ civil_status.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.civil_status_type_id" class="error text-danger" for="civil_status_type_id">{{ errors.civil_status_type_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations" class="form-label">Observaciones</label>
                                                <textarea v-model="observations" name="observations" id="observations" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                                <span v-if="errors && errors.observations" class="error text-danger" for="observations">{{ errors.observations[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información de Domicilio
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="residence_province_id" class="form-label">Dpto De Residencia*</label>
                                                <!-- <select v-model="residence_province_id" @change="getCities(residence_province_id, 'residence')" class="form-control" name="province" id="residence_province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select> -->

                                                <select 
                                                    v-model="residence_province_id" 
                                                    @change="changeProvince(residence_province_id, 'residence')" 
                                                    class="form-control" 
                                                    name="province" 
                                                    id="residence_province_id"
                                                >
                                                    <option value="" disabled selected hidden>Seleccionar Dpto</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>

                                                <span v-if="errors && errors.residence_province_id" class="error text-danger" for="residence_province_id">{{ errors.residence_province_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="residence_city_id" class="form-label">Municipio de Residencia*</label>
                                                <select v-model="residence_city_id" class="form-control" name="residence_city_id" id="residence_city_id">
                                                    <option value="" disabled selected hidden>Seleccionar Municipio</option>
                                                    <option v-for="city in residence_cities" :value="city.id">{{ city.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.residence_city_id" class="error text-danger" for="residence_city_id">{{ errors.residence_city_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="stratum_type_id" class="form-label">Estrato Social*</label>
                                                <select v-model="stratum_type_id" class="form-control" name="stratum_type_id" id="stratum_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Estrato</option>
                                                    <option v-for="stratum in stratum_types" :value="stratum.id">[{{ stratum.id }}] {{ stratum.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.stratum_type_id" class="error text-danger" for="stratum_type_id">{{ errors.stratum_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="stratum_type_id" class="form-label">Tenencia*</label>
                                                <select v-model="housing_tenure_id" class="form-control" name="housing_tenure_id" id="housing_tenure_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tenencia</option>
                                                    <option v-for="housing_tenure in housing_tenure_types" :value="housing_tenure.id">{{ housing_tenure.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.housing_tenure_id" class="error text-danger" for="housing_tenure_id">{{ errors.housing_tenure_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="address" class="form-label">Dirección*</label>
                                                <input v-model="address" name="address" id="address" type="text" class="form-control" placeholder="Ingrese su dirección">
                                                <span v-if="errors && errors.address" class="error text-danger" for="address">{{ errors.address[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información De Contacto
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="phone" class="form-label">Teléfono fijo</label>
                                                <input v-model="phone" name="phone" id="phone" type="text" class="form-control" placeholder="Ingrese su número fijo">
                                                <span v-if="errors && errors.phone" class="error text-danger" for="phone">{{ errors.phone[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label for="cellphone" class="form-label">Celular*</label>
                                                <input v-model="cellphone" name="cellphone" id="cellphone" type="text" class="form-control" placeholder="Ingrese su número celular">
                                                <span v-if="errors && errors.cellphone" class="error text-danger" for="cellphone">{{ errors.cellphone[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="email" class="form-label">Correo electrónico*</label>
                                                <input v-model="email" name="email" id="email" type="text" class="form-control" placeholder="Ingrese su correo electrónico">
                                                <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
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
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
    components: {
        Cropper,
    },
    props: {
        company_id: {
            default: null,
        },
        provinces: {
            default: null,
        },
        document_types: {
            default: null,
        },
        civil_status_types: {
            default: null,
        },
        sex_types: {
            default: null,
        },
        rh_types: {
            default: null,
        },
        stratum_types: {
            default: null,
        },
        housing_tenure_types: {
            default: null,
        },
        staff_providers: {
            default: null,
        },
    },
    data() {
        return {
            is_loading: false,
            tab_collaborator_status: 'general',
            is_foreigner: false,

            name: '',
            first_surname: '',
            second_surname: '',

            document_type_id: '',
            document_number: '',
            expedition_date: '',
            document_province_id: '',
            document_city_id: '',

            birth_date: '',
            birth_province_id: '',
            birth_city_id: '',

            civil_status_type_id: '',
            sex_type_id: '',
            rh_type_id: '',
            stratum_type_id: '',

            residence_province_id: '',
            residence_city_id: '',
            housing_tenure_id: '',
            staff_provider_id: '',

            document_cities: [],
            birth_cities: [],
            residence_cities: [],

            address: '',
            phone: '',
            cellphone: '',
            email: '',

            observations: '',

            image: '',
            image_src: null,

            errors: null,
        }
    },
    watch: {
        is_foreigner(newValue) {
            if (newValue === true) {
                // Si marca que es extranjero, limpiamos los campos de nacimiento locales
                this.birth_province_id = '';
                this.birth_city_id = '';
                this.birth_cities = []; // Opcional: limpia la lista de ciudades cargadas
            }
        }
    },
    mounted () {
        //
    },
    methods: {
        selectImage() {
            this.$refs.imageInput.click();
        },
        onChangeImage(e) {
            // this.image = e.target.files[0]
            const file = e.target.files[0];
            if (file) {
                // Creamos una URL local para que el cropper la muestre
                this.image_src = URL.createObjectURL(file);
            }
        },
        changeProvince(provinceId, type) {
            // 1. Limpiamos el modelo del municipio correspondiente según el tipo
            if (type === 'document') {
                this.document_city_id = '';
            } else if (type === 'birth') {
                this.birth_city_id = '';
            } else if (type === 'residence') {
                this.residence_city_id = '';
            }

            // 2. Llamamos a la función que obtiene las ciudades
            this.getCities(provinceId, type);
        },

        getCities(province, type) {
            // Validación rápida para evitar llamadas vacías
            if (!province) return;

            let dataSend = {
                "province": province,
            }

            axios.post('/get-cities', dataSend).then(
                ({data}) => {
                    if(type == 'document') {
                        this.document_cities = data.cities
                    } else if(type == 'birth') {
                        this.birth_cities = data.cities
                    } else if(type == 'residence') {
                        this.residence_cities = data.cities
                    }
                })
        },
        storeCollaborator() {
            this.is_loading = true; // ACTIVAR AL INICIO DE TODO EL PROCESO

            let fd = new FormData();

            // 1. La función interna que agrega campos y envía
            const appendFieldsAndSubmit = (formData) => {

                // Agregamos todos los demás campos
                this.appendIfNotEmpty(formData, 'staff_provider_id', this.staff_provider_id);
                this.appendIfNotEmpty(formData, 'name', this.name);
                this.appendIfNotEmpty(formData, 'first_surname', this.first_surname);
                this.appendIfNotEmpty(formData, 'second_surname', this.second_surname);
                this.appendIfNotEmpty(formData, 'document_type_id', this.document_type_id);
                this.appendIfNotEmpty(formData, 'document_number', this.document_number);
                this.appendIfNotEmpty(formData, 'expedition_date', this.expedition_date);
                this.appendIfNotEmpty(formData, 'document_province_id', this.document_province_id);
                this.appendIfNotEmpty(formData, 'document_city_id', this.document_city_id);
                this.appendIfNotEmpty(formData, 'is_foreigner', this.is_foreigner ? 1 : 0);
                this.appendIfNotEmpty(formData, 'birth_province_id', this.birth_province_id);
                this.appendIfNotEmpty(formData, 'birth_city_id', this.birth_city_id);
                this.appendIfNotEmpty(formData, 'birth_date', this.birth_date);
                this.appendIfNotEmpty(formData, 'civil_status_type_id', this.civil_status_type_id);
                this.appendIfNotEmpty(formData, 'sex_type_id', this.sex_type_id);
                this.appendIfNotEmpty(formData, 'rh_type_id', this.rh_type_id);
                this.appendIfNotEmpty(formData, 'observations', this.observations);
                this.appendIfNotEmpty(formData, 'residence_province_id', this.residence_province_id);
                this.appendIfNotEmpty(formData, 'residence_city_id', this.residence_city_id);
                this.appendIfNotEmpty(formData, 'stratum_type_id', this.stratum_type_id);
                this.appendIfNotEmpty(formData, 'housing_tenure_id', this.housing_tenure_id);
                this.appendIfNotEmpty(formData, 'address', this.address);
                this.appendIfNotEmpty(formData, 'phone', this.phone);
                this.appendIfNotEmpty(formData, 'cellphone', this.cellphone);
                this.appendIfNotEmpty(formData, 'email', this.email);

                // 3. Enviamos la petición de Axios
                axios.post('/collaborators', formData).then(
                    (res) => {
                        localStorage.setItem('origin', 'created');
                        window.location.href = '/collaborators';
                        this.errors = null;
                    }).catch(
                    (error) => {
                        if(error && error.response && error.response.data && error.response.data.errors) {
                            console.log(error.response.data.errors);
                            this.errors = error.response.data.errors;
                        }
                    }).finally(() => {
                        this.is_loading = false; // DESACTIVAR AQUÍ (al final de la petición)
                    });
            };

            // 4. Verificamos si hay una imagen para recortar
            if (this.$refs.cropperRef && this.image_src) {
                const { canvas } = this.$refs.cropperRef.getResult();

                if (canvas) {
                    const resizedCanvas = document.createElement('canvas');
                    resizedCanvas.width = 300;
                    resizedCanvas.height = 300;

                    const ctx = resizedCanvas.getContext('2d');
                    ctx.drawImage(canvas, 0, 0, 300, 300);

                    resizedCanvas.toBlob((blob) => {
                        // console.log('Tamaño del Blob REDIMENSIONADO (MB):', (blob.size / 1024 / 1024).toFixed(2));
                        fd.append('image', blob, 'profile_300x300.png');
                        appendFieldsAndSubmit(fd);
                    }, 'image/png');

                } else {
                    // Error de canvas, solo envía los campos
                    appendFieldsAndSubmit(fd);
                }
            } else {
                // Si NO hay imagen, llamamos a la función directamente
                appendFieldsAndSubmit(fd);
            }
        },
        appendIfNotEmpty(fd, key, value) {
            if (value !== null && value !== '' && value !== undefined) {
                fd.append(key, value)
            }
        },
    },
}
</script>

<style scoped>
/* Dale un tamaño fijo al contenedor del cropper */
.cropper-container {
    width: 100%;
    max-width: 500px;
    /* height: 400px; */
    margin-top: 15px;
    border: 1px solid #ccc;
}

.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.85);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-text {
    font-weight: 500;
    color: #333;
}
</style>
