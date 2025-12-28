<template>
    <div>
        <Teleport to="body">
            <div v-if="is_loading" class="loading-overlay">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Procesando...</span>
                </div>
                <p class="loading-text mt-3">Actualizando información, por favor espera...</p>
            </div>
        </Teleport>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="updateCompany" enctype="multipart/form-data">
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
                                                <label class="form-label">Logo de la Empresa</label>
                                                
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-icon rounded me-3" style="width: 80px; height: auto; border: 2px solid #ced4da; overflow: hidden;">
                                                        <img :src="logo_preview" style="width: 100%; height: auto;">
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-primary btn-sm" @click="selectLogoFile">
                                                            <i class="fa fa-upload"></i> Cambiar Logo
                                                        </button>
                                                        <p class="text-muted small mb-0 mt-1">Formatos: JPG, PNG. Máx: 512KB</p>
                                                    </div>
                                                </div>

                                                <input ref="logoFileInput" type="file" accept="image/*" class="d-none" @change="onChangeLogo">

                                                <div v-if="logo_src" class="btn-group btn-group-sm mb-2 w-100" role="group">
                                                    <button type="button" :class="['btn', aspectRatio === 1 ? 'btn-info' : 'btn-outline-info']" @click="setAspectRatio(1)">1:1</button>
                                                    <button type="button" :class="['btn', aspectRatio === 2 ? 'btn-info' : 'btn-outline-info']" @click="setAspectRatio(2)">2:1</button>
                                                    <button type="button" :class="['btn', aspectRatio === 3 ? 'btn-info' : 'btn-outline-info']" @click="setAspectRatio(3)">3:1</button>
                                                    <button type="button" :class="['btn', aspectRatio === 4 ? 'btn-info' : 'btn-outline-info']" @click="setAspectRatio(4)">4:1</button>
                                                </div>

                                                <div v-if="logo_src" class="cropper-container mb-3">
                                                    <cropper
                                                        ref="cropperRef"
                                                        :src="logo_src"
                                                        :stencil-props="{ aspectRatio: aspectRatio }"
                                                        class="company-logo-cropper"
                                                    />
                                                </div>
                                                <span v-if="errors && errors.logo" class="error text-danger">{{ errors.logo[0] }}</span>
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
                                                <span v-if="errors && errors.founded_at" class="error text-danger"
                                                    for="founded_at">{{ errors.founded_at[0] }}</span>
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
                                                <input v-model="x_twitter" name="x_twitter" id="x_twitter" type="text"
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
                    <button type="submit" class="mt-2 btn btn-primary">Actualizar</button>
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
        Cropper 
    },
    props: {
        company: { default: null },
        company_types: { default: null },
        document_types: { default: null },
        provinces: { default: null },
        industry_types: { default: null },
    },
    data() {
        return {
            identification_type_default: null,
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
            status: 0,
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
            
            // Variables de Control
            is_loading: false,
            logo: null,         // Archivo seleccionado
            logo_src: null,     // URL para el Cropper
            aspectRatio: 1,     // Relación de aspecto inicial
            errors: null,       // Un solo objeto de errores
        };
    },
    mounted() {
        this.handleChangeCompanyType()
        this.getCities(this.province_id)
        if (this.company && this.company.is_active && this.company.is_active == 1) {
            document.getElementById('is_active').checked = true
        }
    },
    computed: {
        logo_preview() {
            if (this.logo_src) return this.logo_src;
            return (this.company && this.company.logo_url) ? this.company.logo_url : '/images/default-profile.jpeg';
        }
    },
    watch: {
        company: {
            deep: true,
            handler(newVal) {
                // Sincronización de datos al cargar
                this.company_type_id = newVal.company_type_id || '';
                this.company_name = newVal.company_name || '';
                this.identification_type_id = newVal.identification_type_id || '';
                this.identification_number = newVal.identification_number || '';
                this.province_id = newVal.province_id || '';
                this.city_id = newVal.city_id || '';
                this.address = newVal.address || '';
                this.industry_type_id = newVal.industry_type_id || '';
                this.size = newVal.size || '';
                this.founded_at = newVal.founded_at || '';
                this.status = newVal.is_active == 1 ? 1 : 0;
                this.description = newVal.description || '';
                this.contact_name = newVal.contact_name || '';
                this.contact_first_surname = newVal.contact_first_surname || '';
                this.contact_second_surname = newVal.contact_second_surname || '';
                this.website = newVal.website || '';
                this.email = newVal.email || '';
                this.phone = newVal.phone || '';
                this.cellphone = newVal.cellphone || '';
                this.facebook = newVal.facebook || '';
                this.instagram = newVal.instagram || '';
                this.linkedin = newVal.linkedin || '';
                this.x_twitter = newVal.x_twitter || '';
                this.youtube = newVal.youtube || '';
            }
        }
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
                this.identification_type_id = this.company ? this.company.identification_type_id : '';
            } else {
                this.identification_type_id = 3; // NIT
            }
        },

        updateCompany() {
            this.is_loading = true;
            let fd = new FormData();

            const executeSubmission = (formData) => {
                formData.append('_method', 'PUT');
                formData.append('company_name', this.company_name);
                formData.append('company_type_id', this.company_type_id);
                formData.append('identification_type_id', this.identification_type_id);
                formData.append('identification_number', this.identification_number);
                formData.append('province_id', this.province_id);
                formData.append('city_id', this.city_id);
                formData.append('address', this.address);
                formData.append('industry_type_id', this.industry_type_id);
                formData.append('size', this.size);
                formData.append('founded_at', this.founded_at);
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
                
                const isActive = document.getElementById('is_active').checked ? 1 : 0;
                formData.append('is_active', isActive);

                axios.post(`/companies/${this.company.id}`, formData).then((res) => {
                    localStorage.setItem('origin', 'updated');
                    window.location.href = '/companies';
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
                        fd.append('logo', blob, 'company_logo_updated.png');
                        executeSubmission(fd);
                    }, 'image/png');
                } else {
                    executeSubmission(fd);
                }
            } else {
                executeSubmission(fd);
            }
        }
    },
};
</script>

<style scoped>
/* Asegúrate de incluir estos estilos */
.cropper-container {
    width: 100%;
    background: #f8f9fa;
    border: 1px dashed #ced4da;
    border-radius: 4px;
    overflow: hidden;
}

.company-logo-cropper {
    min-height: 300px; /* IMPORTANTE: Da altura mínima al cropper */
    max-height: 500px;
    width: 100%;
}

.loading-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
</style>
