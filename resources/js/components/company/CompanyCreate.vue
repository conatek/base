<template>
    <div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="storeCompany" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Básica
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <!-- <div class="position-relative mb-3">
                                                <label for="logo" class="form-label">Logo</label>
                                                <div class="input-group">
                                                    <input @change="onChangeLogo" type="file" name="logo" id="logo"
                                                        class="form-control">
                                                </div>
                                                <span v-if="errors && errors.logo" class="error text-danger"
                                                    for="logo">{{ errors.logo[0] }}</span>
                                            </div> -->





                                            <div class="position-relative mb-3">
                                                <label class="form-label">Logo de la Empresa</label>
                                                <input ref="logoFileInput" type="file" accept="image/*" class="d-none"
                                                    @change="onChangeLogo">

                                                <div class="input-group mb-2">
                                                    <button type="button" class="btn btn-primary"
                                                        @click="selectLogoFile">
                                                        <i class="fa fa-upload"></i> Seleccionar Logo
                                                    </button>
                                                    <input type="text" class="form-control"
                                                        :value="logo ? logo.name : ''" readonly
                                                        placeholder="No hay archivo seleccionado">
                                                </div>

                                                <div v-if="logo_src" class="btn-group btn-group-sm mb-2 w-100"
                                                    role="group">
                                                    <button type="button"
                                                        :class="['btn', aspectRatio === 1 ? 'btn-info' : 'btn-outline-info']"
                                                        @click="setAspectRatio(1)">1:1 (Cuadrado)</button>
                                                    <button type="button"
                                                        :class="['btn', aspectRatio === 2 ? 'btn-info' : 'btn-outline-info']"
                                                        @click="setAspectRatio(2)">2:1</button>
                                                    <button type="button"
                                                        :class="['btn', aspectRatio === 3 ? 'btn-info' : 'btn-outline-info']"
                                                        @click="setAspectRatio(3)">3:1</button>
                                                    <button type="button"
                                                        :class="['btn', aspectRatio === 4 ? 'btn-info' : 'btn-outline-info']"
                                                        @click="setAspectRatio(4)">4:1 (Banner)</button>
                                                </div>

                                                <div v-if="logo_src" class="cropper-container">
                                                    <cropper ref="cropperRef" :src="logo_src"
                                                        :stencil-props="{ aspectRatio: aspectRatio }"
                                                        class="company-logo-cropper" />
                                                </div>
                                                <span v-if="errors && errors.logo" class="error text-danger">{{
                                                    errors.logo[0] }}</span>
                                            </div>







                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="company_type_id" class="form-label">Tipo de empresa*</label>
                                                <select v-model="company_type_id" name="company_type_id"
                                                    class="form-control" id="company_type_id"
                                                    @change="handleChangeCompanyType">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo de
                                                        Empresa</option>
                                                    <option v-for="company_type in company_types"
                                                        :value="company_type.id">{{ company_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.company_type_id" class="error text-danger"
                                                    for="company_type_id">{{ errors.company_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="company_name" class="form-label">Nombre*</label>
                                                <input v-model="company_name" name="company_name" id="company_name"
                                                    type="text" class="form-control"
                                                    placeholder="Ingrese nombre empresa">
                                                <span v-if="errors && errors.company_name" class="error text-danger"
                                                    for="company_name">{{ errors.company_name[0] }}</span>
                                            </div>
                                        </div>

                                        <!-- <div v-if="company_type_id == 1" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="identification_type_id" class="form-label">Tipo de identificación*</label>
                                                <select v-model="identification_type_id" name="identification_type_id" class="form-control"  id="identification_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Identificación</option>
                                                    <option v-for="document_type in document_types" :value="document_type.id">{{ document_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.identification_type_id" class="error text-danger" for="identification_type_id">{{ errors.identification_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div v-else-if="company_type_id == 2 && identification_type_default != null" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="identification_type_id" class="form-label">Tipo de identificación*</label>
                                                <input v-model="identification_type_default.type" name="identification_type_id" id="identification_type_id" type="text" class="form-control" disabled>
                                                <span v-if="errors && errors.identification_type_id" class="error text-danger" for="identification_type_id">{{ errors.identification_type_id[0] }}</span>
                                            </div>
                                        </div> -->

                                        <div v-if="company_type_id == 1" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="identification_type_id" class="form-label">Tipo de
                                                    identificación*</label>
                                                <select v-model="identification_type_id" name="identification_type_id"
                                                    class="form-control" id="identification_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo
                                                        Identificación</option>
                                                    <option v-for="document_type in document_types"
                                                        :value="document_type.id">{{ document_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.identification_type_id"
                                                    class="error text-danger" for="identification_type_id">{{
                                                        errors.identification_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div v-else-if="company_type_id == 2" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="identification_type_id" class="form-label">Tipo de
                                                    identificación*</label>
                                                <select v-model="identification_type_id" name="identification_type_id"
                                                    class="form-control" id="identification_type_id" disabled>
                                                    <option value="" disabled selected hidden>Seleccionar Tipo
                                                        Identificación</option>
                                                    <option v-for="document_type in document_types"
                                                        :value="document_type.id">{{ document_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.identification_type_id"
                                                    class="error text-danger" for="identification_type_id">{{
                                                        errors.identification_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="identification_number" class="form-label">Número de
                                                    identificación*</label>
                                                <input v-model="identification_number" name="identification_number"
                                                    id="identification_number" type="text" class="form-control"
                                                    placeholder="Ingrese número identificación">
                                                <span v-if="errors && errors.identification_number"
                                                    class="error text-danger" for="identification_number">{{
                                                        errors.identification_number[0] }}</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <!-- <div class="position-relative mb-3">
                                                <label for="province_id" class="form-label">Departamento*</label>
                                                <select v-model="province_id" @change="getCities(province_id)" name="province_id" class="form-control"  id="province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Departamento</option>
                                                    <option v-for="province in provinces" :value="province.id">{{ province.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.province_id" class="error text-danger" for="province_id">{{ errors.province_id[0] }}</span>
                                            </div> -->

                                            <div class="position-relative mb-3">
                                                <label for="province_id" class="form-label">Departamento*</label>
                                                <select v-model="province_id" @change="changeProvince(province_id)"
                                                    name="province_id" class="form-control" id="province_id">
                                                    <option value="" disabled selected hidden>Seleccionar Departamento
                                                    </option>
                                                    <option v-for="province in provinces" :value="province.id">{{
                                                        province.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.province_id" class="error text-danger"
                                                    for="province_id">{{ errors.province_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="city_id" class="form-label">Municipio*</label>
                                                <select v-model="city_id" name="city_id" class="form-control"
                                                    id="city_id">
                                                    <option value="" disabled selected hidden>Seleccionar Municipio
                                                    </option>
                                                    <option v-for="city in cities" :value="city.id">{{ city.name }}
                                                    </option>
                                                </select>
                                                <span v-if="errors && errors.city_id" class="error text-danger"
                                                    for="city_id">{{ errors.city_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="address" class="form-label">Dirección</label>
                                                <input v-model="address" name="address" id="address" type="text"
                                                    class="form-control" placeholder="Ingrese dirección">
                                                <span v-if="errors && errors.address" class="error text-danger"
                                                    for="address">{{ errors.address[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="industry_type_id" class="form-label">Industria*</label>
                                                <select v-model="industry_type_id" name="industry_type_id"
                                                    class="form-control" id="industry_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Sector
                                                    </option>
                                                    <option v-for="industry_type in industry_types"
                                                        :value="industry_type.id">{{ industry_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.industry_type_id" class="error text-danger"
                                                    for="industry_type_id">{{ errors.industry_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="size" class="form-label">Cantidad de empleados*</label>
                                                <input v-model="size" name="size" id="size" type="text"
                                                    class="form-control" placeholder="Ingrese cantidad de empleados">
                                                <span v-if="errors && errors.size" class="error text-danger"
                                                    for="size">{{ errors.size[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="founded_at" class="form-label">Fecha de fundación*</label>
                                                <input v-model="founded_at" name="founded_at" id="founded_at"
                                                    type="date" class="form-control"
                                                    placeholder="Ingrese fecha de nacimiento">
                                                <span v-if="errors_relative_data && errors_relative_data.founded_at"
                                                    class="error text-danger" for="founded_at">{{
                                                        errors_relative_data.founded_at[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                            <div class="form-group clearfix my-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" name="is_active" id="is_active" value="">
                                                    <label for="is_active" class="ml-2">¿Empresa activa?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="description" class="form-label">Descripción</label>
                                                <textarea v-model="description" name="description" id="description"
                                                    type="text" class="form-control"
                                                    placeholder="Ingrese descripción de la empresa" rows="7"
                                                    cols="50"></textarea>
                                                <span v-if="errors && errors.description" class="error text-danger"
                                                    for="description">{{ errors.description[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información de Contacto Principal
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="contact_name" class="form-label">Nombres*</label>
                                                <input v-model="contact_name" name="contact_name" id="contact_name"
                                                    type="text" class="form-control" placeholder="Ingrese nombre(s)">
                                                <span v-if="errors && errors.contact_name" class="error text-danger"
                                                    for="contact_name">{{ errors.contact_name[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_first_surname" class="form-label">Primer
                                                    apellido*</label>
                                                <input v-model="contact_first_surname" name="contact_first_surname"
                                                    id="contact_first_surname" type="text" class="form-control"
                                                    placeholder="Ingrese primer apellido">
                                                <span v-if="errors && errors.contact_first_surname"
                                                    class="error text-danger" for="contact_first_surname">{{
                                                        errors.contact_first_surname[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="contact_second_surname" class="form-label">Segundo
                                                    apellido</label>
                                                <input v-model="contact_second_surname" name="contact_second_surname"
                                                    id="contact_second_surname" type="text" class="form-control"
                                                    placeholder="Ingrese segundo apellido">
                                                <span v-if="errors && errors.contact_second_surname"
                                                    class="error text-danger" for="contact_second_surname">{{
                                                        errors.contact_second_surname[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="website" class="form-label">Sitio web</label>
                                                <input v-model="website" name="website" id="website" type="text"
                                                    class="form-control" placeholder="Ingrese url de sitio web">
                                                <span v-if="errors && errors.website" class="error text-danger"
                                                    for="website">{{ errors.website[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="email" class="form-label">Correo electrónico</label>
                                                <input v-model="email" name="email" id="email" type="text"
                                                    class="form-control" placeholder="Ingrese correo electrónico">
                                                <span v-if="errors && errors.email" class="error text-danger"
                                                    for="email">{{ errors.email[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="phone" class="form-label">Teléfono</label>
                                                <input v-model="phone" name="phone" id="phone" type="text"
                                                    class="form-control" placeholder="Ingrese teléfono">
                                                <span v-if="errors && errors.phone" class="error text-danger"
                                                    for="phone">{{ errors.phone[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="cellphone" class="form-label">Celular</label>
                                                <input v-model="cellphone" name="cellphone" id="cellphone" type="text"
                                                    class="form-control" placeholder="Ingrese celular">
                                                <span v-if="errors && errors.cellphone" class="error text-danger"
                                                    for="cellphone">{{ errors.cellphone[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información de Redes Sociales
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- <div class="col-sm-12 col-md-6 col-lg-6"> -->
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="facebook" class="form-label">Facebook</label>
                                                <input v-model="facebook" name="facebook" id="facebook" type="text"
                                                    class="form-control" placeholder="Ingrese url facebook">
                                                <span v-if="errors && errors.facebook" class="error text-danger"
                                                    for="facebook">{{ errors.facebook[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="instagram" class="form-label">Instagram</label>
                                                <input v-model="instagram" name="instagram" id="instagram" type="text"
                                                    class="form-control" placeholder="Ingrese url instagram">
                                                <span v-if="errors && errors.instagram" class="error text-danger"
                                                    for="instagram">{{ errors.instagram[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="linkedin" class="form-label">LinkedIn</label>
                                                <input v-model="linkedin" name="linkedin" id="linkedin" type="text"
                                                    class="form-control" placeholder="Ingrese url linkedin">
                                                <span v-if="errors && errors.linkedin" class="error text-danger"
                                                    for="linkedin">{{ errors.linkedin[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="x_twitter" class="form-label">X (Twitter)</label>
                                                <input v-model="x" name="x_twitter" id="x_twitter" type="text"
                                                    class="form-control" placeholder="Ingrese url de X">
                                                <span v-if="errors && errors.x_twitter" class="error text-danger"
                                                    for="x_twitter">{{ errors.x_twitter[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="youtube" class="form-label">YouTube</label>
                                                <input v-model="youtube" name="youtube" id="youtube" type="text"
                                                    class="form-control" placeholder="Ingrese url de YouTube">
                                                <span v-if="errors && errors.youtube" class="error text-danger"
                                                    for="youtube">{{ errors.youtube[0] }}</span>
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
    components: { Cropper },
    props: {
        company_types: { default: null },
        document_types: { default: null },
        provinces: { default: null },
        industry_types: { default: null },
    },
    data() {
        return {
            identification_type_default: null,
            // Agrupamos las variables de la empresa
            company_type_id: '',
            company_name: '',
            identification_type_id: '',
            identification_number: '',
            province_id: '',
            city_id: '',
            address: '',
            industry_type_id: '',
            size: '',
            founded_at: '',
            status: '',
            description: '',
            contact_name: '',
            contact_first_surname: '',
            contact_second_surname: '',
            website: '',
            email: '',
            phone: '',
            cellphone: '',
            facebook: '',
            instagram: '',
            linkedin: '',
            x_twitter: '',
            youtube: '',

            cities: [],
            errors: null,

            // Variables para el Cropper y Carga
            is_loading: false,
            logo: null,      // Aquí se guarda el archivo para el nombre
            logo_src: null,  // URL para la vista previa del cropper
            aspectRatio: 1,
        };
    },
    methods: {
        selectLogoFile() {
            this.$refs.logoFileInput.click();
        },

        // UN SOLO MÉTODO onChangeLogo
        onChangeLogo(e) {
            const file = e.target.files[0];
            if (file) {
                this.logo = file;
                this.logo_src = URL.createObjectURL(file);
            }
        },

        setAspectRatio(ratio) {
            this.aspectRatio = ratio;
        },

        changeProvince(province) {
            this.city_id = '';
            this.getCities(province);
        },

        getCities(province) {
            if (!province) return;
            axios.post('/get-cities', { "province": province }).then(({ data }) => {
                this.cities = data.cities;
            });
        },

        handleChangeCompanyType() {
            if (this.company_type_id == 1) {
                this.identification_type_id = '';
            } else {
                this.identification_type_id = 3; // NIT
            }
        },

        storeCompany() {
            this.is_loading = true;
            let fd = new FormData();

            // Función que hace el envío final
            const executeSubmission = (formData) => {
                // Si no se procesó un recorte pero hay un archivo original, lo enviamos
                if (!formData.has('logo') && this.logo) {
                    formData.append('logo', this.logo);
                }

                formData.append('company_type_id', this.company_type_id);
                formData.append('company_name', this.company_name);
                formData.append('identification_type_id', this.identification_type_id);
                formData.append('identification_number', this.identification_number);
                formData.append('province_id', this.province_id);
                formData.append('city_id', this.city_id);
                formData.append('address', this.address);
                formData.append('industry_type_id', this.industry_type_id);
                formData.append('size', this.size);
                formData.append('founded_at', this.founded_at);
                formData.append('status', this.status);
                formData.append('description', this.description);
                formData.append('contact_name', this.contact_name);
                formData.append('contact_first_surname', this.contact_first_surname);
                formData.append('contact_second_surname', this.contact_second_surname);
                formData.append('website', this.website);
                formData.append('email', this.email);
                formData.append('phone', this.phone);
                formData.append('cellphone', this.cellphone);
                formData.append('facebook', this.facebook);
                formData.append('instagram', this.instagram);
                formData.append('linkedin', this.linkedin);
                formData.append('x_twitter', this.x_twitter);
                formData.append('youtube', this.youtube);

                axios.post('/companies', formData).then((res) => {
                    localStorage.setItem('origin', 'created');
                    window.location.href = `/companies`;
                }).catch((error) => {
                    if (error?.response?.data?.errors) {
                        this.errors = error.response.data.errors;
                    }
                }).finally(() => {
                    this.is_loading = false;
                });
            };

            // Lógica del Cropper
            if (this.$refs.cropperRef && this.logo_src) {
                const { canvas } = this.$refs.cropperRef.getResult();
                if (canvas) {
                    const targetWidth = 600;
                    const targetHeight = targetWidth / this.aspectRatio;

                    const resizedCanvas = document.createElement('canvas');
                    resizedCanvas.width = targetWidth;
                    resizedCanvas.height = targetHeight;
                    const ctx = resizedCanvas.getContext('2d');
                    ctx.drawImage(canvas, 0, 0, targetWidth, targetHeight);

                    resizedCanvas.toBlob((blob) => {
                        fd.append('logo', blob, 'company_logo.png');
                        executeSubmission(fd);
                    }, 'image/png');
                } else {
                    executeSubmission(fd);
                }
            } else {
                executeSubmission(fd);
            }
        },
    },
};
</script>

<style scoped>
.cropper-container {
    width: 100%;
    background: #f8f9fa;
    border: 1px dashed #ced4da;
    border-radius: 4px;
    overflow: hidden;
}

.company-logo-cropper {
    max-height: 400px;
    width: 100%;
}

/* Estilos del overlay (copiados de tu UserIndex) */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
</style>
