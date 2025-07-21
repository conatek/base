<template>
    <div>
        <div class="app-page-title">
            <div v-if="selected_company == null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-building" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Listado de Empresas
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="addCompany()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-culture text-success"></i>
                    </div>
                    <div>
                        Detalle de la Empresa
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company == null && add_company == true && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-culture text-success"></i>
                    </div>
                    <div>
                        Agregar Empresa
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company != null && add_company == false && edit_company == true && load_collaborators == false && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-culture text-success"></i>
                    </div>
                    <div>
                        Editar Empresa
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == true && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users text-success"></i>
                    </div>
                    <div>
                        Cargar Colaboradores
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users text-success"></i>
                    </div>
                    <div>
                        Agregar Administrador
                    </div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i>
                        Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == true" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users text-success"></i>
                    </div>
                    <div>
                        Editar Administrador
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
        <!-- <div class="main-card mb-3 card">
            <div class="card-body"> -->
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="origin == 'updated'" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="pe-2">
                                <i class="fa fa-star"></i>
                            </span>
                            Empresa actualizada correctamente!
                        </div>
                        <div v-else-if="origin == 'created'" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="pe-2">
                                <i class="fa fa-star"></i>
                            </span>
                            Empresa creada correctamente!
                        </div>
                        <div v-else-if="origin == 'deleted'" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="pe-2">
                                <i class="fa fa-star"></i>
                            </span>
                            Empresa eliminada correctamente!
                        </div>
                    </div>
                </div>
                <div v-if="selected_company == null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
                            <div class="input-group mb-3">
                                <div class="input-group-text">
                                    <div class="">
                                        <i class="fa fa-search fa-w-16 "></i>
                                    </div>
                                </div>
                                <input v-model="search" @input="handleSearch" placeholder="Buscar Empresa ..." type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div v-if="companies !== null" class="row">
                        <div v-for="company in paginatedData" :key="company.id" class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
                            <div class="card-profile mb-3">
                                <div class="img-avatar">
                                    <img v-if="company && company.logo_url" :src="company.logo_url" :alt="company.company_name">
                                    <img v-else :src="'/images/default-profile.jpeg'" :alt="company ? company.company_name : 'Default profile'">
                                </div>
                                <div class="card-profile-text">
                                    <div class="portada"></div>
                                    <div class="title-total">
                                        <div class="title text-truncate">Sector de la Empresa</div>
                                        <div class="name-profile text-truncate" style="border-bottom: 1px dotted #127cb3; padding-bottom: 10px; margin-bottom: 10px;">{{ company ? company.company_name : '' }}</div>
                                        <div class="email-profile text-truncate">{{ company ? company.email : '' }}</div>
                                        <div class="cellphone-profile text-truncate">{{ company ? company.cellphone : '' }}</div>

                                        <!-- <div class="desc"></div> -->
                                        <div class="actions">
                                            <button v-if="company" @click="getCompany(company.id)"><i class="fa fa-eye"></i></button>
                                            <button v-if="company" @click="editCompany(company.id)"><i class="fa fa-edit"></i></button>
                                            <button v-if="company" @click="showDeleteAlert('deleteCompany', company.id)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav v-if="companies !== null" class="" aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a @click="getPreviousPage()" class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">«</span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                            </li>
                            <li v-for="page in totalPages" class="page-item" :class="currentPage == page ? 'active' : ''">
                                <a @click="getPageData(page)" class="page-link">{{ page }}</a>
                            </li>
                            <li class="page-item">
                                <a @click="getNextPage()" class="page-link" aria-label="Next">
                                    <span aria-hidden="true">»</span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div v-if="selected_company !== null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false">
                    <company-detail
                        @editCompany="editCompany"
                        @loadCollaborators="loadCollaborators"
                        @addUserAdmin="addUserAdmin"
                        @editUserAdmin="editUserAdmin"
                        :company="selected_company"
                        :company_type="companyData.company_type"
                        :industry_type="companyData.industry_type"
                        :identification_type="companyData.identification_type"
                        :province="companyData.province"
                        :city="companyData.city"
                    ></company-detail>
                </div>
                <div v-if="selected_company == null && add_company == true && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == false">
                    <company-create
                        :company_types="selectsDataCreate.company_types"
                        :document_types="selectsDataCreate.document_types"
                        :provinces="selectsDataCreate.provinces"
                        :industry_types="selectsDataCreate.industry_types"
                    ></company-create>
                </div>
                <div v-if="selected_company != null && add_company == false && edit_company == true && load_collaborators == false && add_user_admin == false && edit_user_admin == false">
                    <company-edit
                        :company="companyDataEdit.company"
                        :company_types="companyDataEdit.company_types"
                        :document_types="companyDataEdit.document_types"
                        :provinces="companyDataEdit.provinces"
                        :industry_types="companyDataEdit.industry_types"
                    ></company-edit>
                </div>
                <div v-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == true && add_user_admin == false && edit_user_admin == false">
                    <company-collaborators :company_id="selected_company.id"></company-collaborators>
                </div>
                <div v-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == true && edit_user_admin == false" class="main-card mb-3 card">
                    <div class="card-body">
                        <form @submit.prevent="storeUserAdmin" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingresa el nombre del ususario" autofocus>
                                        <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input v-model="email" name="email" id="email" type="email" class="form-control" placeholder="Ingresa el correo electrónico" autocomplete="new-password">
                                        <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="image" class="form-label">Imagen</label>
                                        <div class="input-group">
                                            <input @change="onChangeImage" type="file" name="image" id="image" class="form-control">
                                        </div>
                                        <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input v-model="password" name="password" id="password" type="password" class="form-control" placeholder="Ingresa la contraseña solo si la deseas modificar" autocomplete="new-password">
                                        <span v-if="errors && errors.password" class="error text-danger" for="password">{{ errors.password[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
                <div v-if="selected_company != null && add_company == false && edit_company == false && load_collaborators == false && add_user_admin == false && edit_user_admin == true" class="main-card mb-3 card">
                    <div class="card-body">
                        <form @submit.prevent="updateUserAdmin" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input v-model="user_admin.name" name="name" id="name" type="text" class="form-control" placeholder="Ingresa el nombre del ususario" autofocus>
                                        <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input v-model="user_admin.email" name="email" id="email" type="email" class="form-control" placeholder="Ingresa el correo electrónico" autocomplete="new-password">
                                        <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="image" class="form-label">Imagen</label>
                                        <div class="input-group">
                                            <input @change="onChangeImage" type="file" name="image" id="image" class="form-control">
                                        </div>
                                        <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input v-model="password" name="password" id="password" type="password" class="form-control" placeholder="Ingresa la contraseña solo si la deseas modificar" autocomplete="new-password">
                                        <span v-if="errors && errors.password" class="error text-danger" for="password">{{ errors.password[0] }}</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="mt-2 btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>


            <!-- </div>
        </div> -->
    </div>
</template>

<script>
import { add } from 'lodash'

export default {
    props: {
        companies: {
            default: null,
        },
    },
    data() {
        return {
            loading: 0,

            message: '',

            selected_company: null,
            add_company: false,
            edit_company: false,
            load_collaborators: false,
            add_user_admin: false,
            edit_user_admin: false,

            companyData: null,
            companyDataEdit: null,
            selectsDataCreate: null,

            companiesData: null,
            companiesPerPage: 12,
            companiesWithFilter: false,
            paginatedData: [],
            currentPage: 1,
            totalPages: 0,
            search: '',
            filteredCompanies: [],

            name: '',
            email: '',
            image: null,
            password: null,

            user_admin: null,

            origin: '',
        }
    },
    mounted () {
        this.getOrigin()

        this.getTotalPages(this.companies)
        this.getPageData(1)
    },
    methods: {
        showDeleteAlert(action, item) {
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
                if(action == 'deleteCompany') {
                    this.deleteCompany(item)
                }
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
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
            this.selected_company = null
            this.add_company = false
            this.edit_company = false
            this.load_collaborators = false
            this.add_user_admin = false;
            this.edit_user_admin = false;
        },
        getOrigin() {
            const origin = localStorage.getItem('origin');
            if (origin !== null) {
                this.origin = origin;
                localStorage.removeItem('origin');
            }
            setTimeout(() => {
                this.origin = '';
            }, 3000);
        },
        handleSearch() {
            if (this.search.length > 0) {
                this.companiesWithFilter = true;

                this.filteredCompanies = this.companies.filter(company => {
                    return (
                        (company.company_name && company.company_name.toLowerCase().includes(this.search.toLowerCase())) ||
                        (company.identification_number && company.identification_number.toLowerCase().includes(this.search.toLowerCase())) ||
                        (company.email && company.email.toLowerCase().includes(this.search.toLowerCase())) ||
                        (company.cellphone && company.cellphone.toLowerCase().includes(this.search.toLowerCase()))
                    );
                });

                this.getTotalPages(this.filteredCompanies);
                this.getPageData(1); // Siempre muestra la primera página después de buscar
            } else {
                this.companiesWithFilter = false;
                this.getTotalPages(this.companies);
                this.getPageData(1); // Muestra la primera página al limpiar la búsqueda
            }
        },
        getTotalPages(data) {
            this.totalPages = Math.ceil(data.length / this.companiesPerPage)
        },
        getPageData(page) {
            this.paginatedData = [];
            let start = (page * this.companiesPerPage) - this.companiesPerPage;
            let end = (page * this.companiesPerPage);

            // Utiliza las empresas filtradas si hay una búsqueda activa, de lo contrario usa todas las empresas
            const data = this.companiesWithFilter ? this.filteredCompanies : this.companies;

            this.paginatedData = data.slice(start, end);
            this.currentPage = page;
        },
        getPreviousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
            this.getPageData(this.currentPage);
        },

        getNextPage() {
            const data = this.companiesWithFilter ? this.filteredCompanies : this.companies;
            if (this.currentPage < Math.ceil(data.length / this.companiesPerPage)) {
                this.currentPage++;
            }
            this.getPageData(this.currentPage);
        },
        getCompany(company){
            this.selected_company = this.companies.find(c => c.id === company)
            this.add_company = false
            this.edit_company = false
            this.load_collaborators = false
            this.add_user_admin = false
            this.edit_user_admin = false

            axios.get(`/companies/${company}`).then(
                (res) => {
                    this.companyData = res.data
                    // localStorage.setItem('origin', 'deleted');

                    // url = `/collaborators`
                    // window.location.href = url

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        addCompany(){
            // this.$router.push({ name: 'collaborators.create' })
            this.selected_company = null
            this.add_company = true
            this.edit_company = false
            this.load_collaborators = false
            this.add_user_admin = false
            this.edit_user_admin = false

            axios.get(`/companies/create`).then(
                (res) => {
                    this.selectsDataCreate = res.data
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        editCompany(company){
            this.selected_company = this.companies.find(c => c.id === company)
            this.add_company = false
            this.edit_company = true
            this.load_collaborators = false
            this.add_user_admin = false
            this.edit_user_admin = false

            axios.get(`/companies/${company}/edit`).then(
                (res) => {
                    this.companyDataEdit = res.data
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        loadCollaborators(company){
            this.selected_company = this.companies.find(c => c.id === company)
            this.add_company = false
            this.edit_company = false
            this.load_collaborators = true
            this.add_user_admin = false
            this.edit_user_admin = false
        },
        addUserAdmin(company) {
            this.selected_company = this.companies.find(c => c.id === company)
            this.add_company = false
            this.edit_company = false
            this.load_collaborators = false
            this.add_user_admin = true;
            this.edit_user_admin = false;

            // Emit an event to the parent component to handle adding a user admin
            this.$emit('addUserAdmin', company);
        },
        editUserAdmin(user_admin) {
            this.user_admin = user_admin;
            this.add_company = false;
            this.edit_company = false;
            this.load_collaborators = false;
            this.add_user_admin = false;
            this.edit_user_admin = true;

            // Emit an event to the parent component to handle editing a user admin
            this.$emit('editUserAdmin', user_admin);
        },
        storeUserAdmin() {
            const selected_roles = ["Admin"]; // Asignar el rol "Admin" por defecto
            let fd = new FormData()

            fd.append('company_id', this.selected_company.id)
            fd.append('name', this.name)
            fd.append('email', this.email)
            if (this.image) {
                fd.append('image', this.image);
            }
            if (this.password) {
                fd.append('password', this.password)
            }
            selected_roles.forEach((role, index) => {
                fd.append(`roles[${index}]`, role);
            });

            axios.post('/users', fd).then(
                (res) => {
                    // localStorage.setItem('origin', 'created');

                    // this.successfully_created_message = true
                    // this.successfully_updated_message = false
                    // this.successfully_deleted_message = false

                    // this.getMessage(res.data.message)

                    // this.getUsers();

                    this.add_company = false
                    this.edit_company = false
                    this.load_collaborators = false
                    this.add_user_admin = false;
                    this.edit_user_admin = false;

                    // window.location.href = '/users'
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        updateUserAdmin() {
            const selected_roles = ["Admin"];
            let fd = new FormData()

            fd.append('company_id', this.selected_company.id)
            fd.append('name', this.user_admin.name)
            fd.append('email', this.user_admin.email)
            if (this.image) {
                fd.append('image', this.image);
            }
            if (this.password) {
                fd.append('password', this.password)
            }
            selected_roles.forEach((role, index) => {
                fd.append(`roles[${index}]`, role);
            });
            fd.append('_method', 'PUT');

            axios.post(`/users/${this.user_admin.id}`, fd).then(
                (res) => {

                    this.add_company = false
                    this.edit_company = false
                    this.load_collaborators = false
                    this.add_user_admin = false;
                    this.edit_user_admin = false;

                    // window.location.href = '/users'
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        deleteCompany(id){
            // console.log('Eliminar empresa: ' + id);

            let url = ''
            axios.delete(`/companies/${id}/destroy`).then(
                (res) => {
                    localStorage.setItem('origin', 'deleted');

                    // this.getMessage(res.data.message)

                    url = `/companies`
                    window.location.href = url
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        // console.log(error.response.data.errors)
                        this.errors = error.response.data.errors
                    }
                })
        },
    },
}
</script>

<style>
    @import './../../assets/css/custom.css';
</style>
