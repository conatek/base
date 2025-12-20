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
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i :class="pageConfig.iconClass" :style="pageConfig.iconStyle"></i>
                    </div>
                    <div>
                        {{ pageConfig.title }}
                    </div>
                </div>
                <div class="page-title-actions">
                    <template v-if="viewState === 'list'">
                        <a href="/report/collaborators" class="btn btn-mh-dark-blue me-3">
                            <i class="fa fa-file-contract"></i>
                            Reporte de Colaboradores
                        </a>
                        <button @click="addCollaborator()" class="btn btn-mh-dark-blue me-3">
                            <i class="fa fa-plus"></i>
                            Agregar
                        </button>
                    </template>

                    <template v-else>
                        <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                            <i class="fa fa-arrow-left"></i>
                            Volver al listado
                        </button>
                    </template>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div v-if="alertMessage" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                    <span class="pe-2">
                        <i class="fa fa-star"></i>
                    </span>

                    {{ alertMessage }}
                </div>

            </div>
        </div>
        <div v-if="viewState === 'list'">
            <!-- <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <div class="">
                                <i class="fa fa-search fa-w-16 "></i>
                            </div>
                        </div>
                        <input v-model="search" @input="handleSearch" placeholder="Buscar Colaborador ..." type="text" class="form-control">
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                        <input 
                            v-model="search" 
                            @input="handleSearch" 
                            placeholder="Buscar (Nombre, Doc, Email)..." 
                            type="text" 
                            class="form-control"
                        >
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa fa-user-tag"></i></div>
                        <select v-model="statusFilter" @change="handleSearch" class="form-select form-control">
                            <option value="all">Todos los colaboradores</option>
                            <option value="active">Solo Activos</option>
                            <option value="inactive">Solo Inactivos</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa fa-file-contract"></i></div>
                        <select v-model="contractFilter" @change="handleSearch" class="form-select form-control">
                            <option value="all">Cualquier estado de contrato</option>
                            <option value="vigente">Con Contrato Vigente</option>
                            <option value="no_vigente">Sin Contrato Vigente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div v-if="collaborators !== null" class="row">
                <div v-for="collaborator in paginatedData" :key="collaborator.id" class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="card-profile mb-3">
                        <div class="img-avatar">
                            <img v-if="collaborator && collaborator.image_url" :src="collaborator.image_url">
                            <img v-else :src="'/images/default-profile.jpeg'" :alt="collaborator ? collaborator.name : 'Default profile'">
                        </div>
                        <div class="card-profile-text">
                            <div class="portada">
                                <div class="icon-grid">
                                    <a @click="showCollaboratorContract(collaborator.id)" title="Contratos"> <i class="fa fa-file-contract"></i></a>
                                    <a @click="showCollaboratorSocialSecurity(collaborator.id)" title="Seguridad Social e Información Bancaria"> <i class="fa fa-handshake"></i></a>
                                    <a @click="showCollaboratorAbsence(collaborator.id)" title="Ausentismo"> <i class="fa fa-clock"></i></a>
                                </div>
                            </div>
                            <div class="title-total">
                                <div class="title d-flex justify-content-end align-items-center">
                                    <span v-if="collaborator && collaborator.hasActiveContract && collaborator.hasActiveContract == true"
                                        @click="showCollaboratorContract(collaborator.id)"
                                        class="badge rounded-pill mx-2"
                                        :class="collaborator.hasActiveContract ? 'bg-success' : 'bg-danger'"
                                        style="cursor: pointer;"
                                    >
                                        Vigente
                                    </span>
                                    <span v-else @click="showCollaboratorContract(collaborator.id)"
                                        class="badge rounded-pill mx-2"
                                        :class="collaborator.hasActiveContract ? 'bg-success' : 'bg-danger'"
                                        style="cursor: pointer;"
                                    >
                                        No Vigente
                                    </span>

                                    <span v-if="collaborator && collaborator.is_active == 1"
                                        @click="deactivateCollaborator(collaborator.id)"
                                        class="badge rounded-pill bg-success"
                                        style="cursor: pointer;"
                                    >
                                        Activo
                                    </span>
                                    <span v-else @click="activateCollaborator(collaborator.id)"
                                        class="badge rounded-pill bg-danger"
                                        style="cursor: pointer;"
                                    >
                                        Inactivo
                                    </span>
                                </div>

                                <div>
                                    <div class="name-profile text-truncate">{{ collaborator ? collaborator.name : '' }}</div>
                                    <div class="surname-profile text-truncate" style="border-bottom: 1px dotted #127cb3; padding-bottom: 10px; margin-bottom: 10px;">{{ collaborator ? collaborator.first_surname : '' }} {{ collaborator ? collaborator.second_surname : '' }}</div>
                                </div>

                                <div>
                                    <div class="cellphone-profile text-truncate">{{ collaborator && collaborator.position ? collaborator.position.name : 'Cargo sin definir' }}</div>
                                    <div class="email-profile text-truncate">{{ collaborator ? collaborator.email : '' }}</div>
                                </div>

                                <div class="d-flex justify-content-end align-items-center" style="padding: 16px;">
                                    <a v-if="collaborator" @click="getCollaborator(collaborator.id)" class="btn btn-warning btn-sm mx-2"><i class="fa fa-eye"></i> Ver</a>
                                    <a v-if="collaborator" @click="editCollaborator(collaborator.id)" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</a>
                                    <!-- <button v-if="collaborator && collaborator.is_active == 1" @click="deactivateCollaborator(collaborator.id)" class="btn btn-primary btn-sm"><i class="fa fa-toggle-on"></i> Inactivar</button>
                                    <button v-else-if="collaborator && collaborator.is_active == 0" @click="activateCollaborator(collaborator.id)" class="btn btn-primary btn-sm"><i class="fa fa-toggle-off"></i> Activar</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav v-if="collaborators !== null" class="" aria-label="Page navigation example">
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
        <div v-else-if="viewState === 'detail' && collaboratorData">
            <collaborator-show
                @editCollaborator="editCollaborator"
                :collaborator="selected_collaborator"
                :document_type="collaboratorData.document_type"
                :document_province="collaboratorData.document_province"
                :document_city="collaboratorData.document_city"
                :birth_province="collaboratorData.birth_province"
                :birth_city="collaboratorData.birth_city"
                :residence_province="collaboratorData.residence_province"
                :residence_city="collaboratorData.residence_city"
                :civil_status="collaboratorData.civil_status"
                :sex_type="collaboratorData.sex_type"
                :rh_type="collaboratorData.rh_type"
                :stratum_type="collaboratorData.stratum_type"
                :highest_academic_achievement="collaboratorData.highest_academic_achievement"
                :housing_tenure="collaboratorData.housing_tenure"
                :staff_provider="collaboratorData.staff_provider"
                :relationship_types="collaboratorData.relationship_types"
                :occupation_types="collaboratorData.occupation_types"
                :sex_types="collaboratorData.sex_types"
                :achievement_types="collaboratorData.achievement_types"
                :examination_types="collaboratorData.examination_types"
                :home_visit_types="collaboratorData.home_visit_types"
                :contractual_documents_types="collaboratorData.contractual_documents_types"
            ></collaborator-show>
        </div>
        <div v-else-if="viewState === 'add' && selectsDataCreate">
            <collaborator-create
                :document_types="selectsDataCreate.document_types"
                :sex_types="selectsDataCreate.sex_types"
                :civil_status_types="selectsDataCreate.civil_status_types"
                :rh_types="selectsDataCreate.rh_types"
                :stratum_types="selectsDataCreate.stratum_types"
                :housing_tenure_types="selectsDataCreate.housing_tenure_types"
                :provinces="selectsDataCreate.provinces"
                :staff_providers="selectsDataCreate.staff_providers"
            ></collaborator-create>
        </div>
        <div v-else-if="viewState === 'edit' && collaboratorDataEdit">
            <collaborator-edit
                :collaborator="selected_collaborator"
                :document_types="collaboratorDataEdit.document_types"
                :sex_types="collaboratorDataEdit.sex_types"
                :civil_status_types="collaboratorDataEdit.civil_status_types"
                :rh_types="collaboratorDataEdit.rh_types"
                :stratum_types="collaboratorDataEdit.stratum_types"
                :housing_tenure_types="collaboratorDataEdit.housing_tenure_types"
                :provinces="collaboratorDataEdit.provinces"
                :staff_providers="collaboratorDataEdit.staff_providers"
            ></collaborator-edit>
        </div>
        <div v-else-if="viewState === 'absence'">
            <collaborator-absence
                :collaborator="selected_collaborator"
                :absence_types="absence_types"
                :absence_subtypes="absence_subtypes"
            ></collaborator-absence>
        </div>
        <div v-else-if="viewState === 'contract'">
            <collaborator-contract
                :collaborator="selected_collaborator"
            ></collaborator-contract>
        </div>
        <div v-else-if="viewState === 'social'">
            <collaborator-social-security
                :collaborator="selected_collaborator"
            ></collaborator-social-security>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        company_id: {
            default: null,
        },
        // collaborators: {
        //     default: null,
        // },
        absence_types: {
            default: null,
        },
        absence_subtypes: {
            default: null,
        },
    },
    data() {
        return {
            is_loading: false,
            collaborators: [],

            message: '',

            selected_collaborator: null,
            add_collaborator: false,
            edit_collaborator: false,
            show_collaborator_absence: false,
            show_collaborator_contract: false,
            show_social_securities: false,

            collaboratorData: null,
            collaboratorDataEdit: null,
            selectsDataCreate: null,

            collaboratorsData: null,
            collaboratorsPerPage: 12,
            collaboratorsWithFilter: false,
            paginatedData: [],
            currentPage: 1,
            totalPages: 0,
            search: '',
            statusFilter: 'all',
            contractFilter: 'all',
            filteredCollaborators: [],

            absences: [],

            viewState: 'list',

            origin: '',
        }
    },
    computed: {
        pageConfig() {
            switch (this.viewState) {
                case 'list':
                    return {
                        title: 'Listado de Colaboradores',
                        iconClass: 'metismenu-icon fa fa-asterisk',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'detail':
                    return {
                        title: 'Detalle del Colaborador',
                        iconClass: 'fa fa-user',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'add':
                    return {
                        title: 'Agregar Colaborador',
                        iconClass: 'fa fa-user',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'edit':
                    return {
                        title: 'Editar Colaborador',
                        iconClass: 'fa fa-user',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'absence':
                    const name = this.selected_collaborator
                        ? `- ${this.selected_collaborator.name} ${this.selected_collaborator.first_surname} ${this.selected_collaborator.second_surname ?? ''}`
                        : '';
                    return {
                        title: `Ausentismo de Colaborador ${name}`,
                        iconClass: 'fa fa-clock',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'contract':
                    return {
                        title: 'Información Contractual',
                        iconClass: 'fa fa-file-contract',
                        iconStyle: 'color: #127cb3;'
                    };
                case 'social':
                    return {
                        title: 'Seguridad Social e Información Bancaria',
                        iconClass: 'fa fa-handshake',
                        iconStyle: 'color: #127cb3;'
                    };
                default:
                    // Un fallback por si acaso
                    return { title: '', iconClass: '', iconStyle: '' };
            }
        },
        alertMessage() {
            const messages = {
                'updated': 'Colaborador actualizado correctamente!',
                'created': 'Colaborador creado correctamente!',
                'deleted': 'Colaborador eliminado correctamente!',
                'deactivated': 'Colaborador inactivado correctamente!',
                'contractual_info_created': 'Información contractual del colaborador creada correctamente!',
                'contractual_info_updated': 'Información contractual del colaborador actualizada correctamente!'
            };

            // Devuelve el mensaje que coincide con 'this.origin'
            // Si 'this.origin' no está en el mapa, devuelve null (y el v-if será false)
            return messages[this.origin] || null;
        }
    },
    mounted () {
        this.getOrigin()

        this.getCollaborators()
        this.getTotalPages(this.collaborators)
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
                if(action == 'deleteCollaborator') {
                    this.deleteCollaborator(item)
                }
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
        },
        returnToList() {
            this.selected_collaborator = null
            this.viewState = 'list';
        },
        getCollaborators() {
            axios.get(`/collaborators/${this.company_id}`)
                .then(response => {
                    this.collaborators = response.data.collaborators;
                    this.getTotalPages(this.collaborators);
                    this.getPageData(1);
                })
                .catch(error => {
                    console.error("Error fetching collaborators:", error);
                })
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
            // 1. Iniciamos con todos los datos
            let results = this.collaborators;

            // 2. FILTRO A: Estado del Colaborador (Activo / Inactivo)
            if (this.statusFilter !== 'all') {
                if (this.statusFilter === 'active') {
                    results = results.filter(c => c.is_active == 1);
                } else if (this.statusFilter === 'inactive') {
                    results = results.filter(c => c.is_active != 1);
                }
            }

            // 3. FILTRO B: Estado del Contrato (Vigente / No Vigente)
            // Este filtro se aplica sobre los resultados del paso anterior
            if (this.contractFilter !== 'all') {
                if (this.contractFilter === 'vigente') {
                    // Verifica que hasActiveContract sea verdadero
                    results = results.filter(c => c.hasActiveContract === true || c.hasActiveContract === 1);
                } else if (this.contractFilter === 'no_vigente') {
                    // Verifica que sea falso o nulo
                    results = results.filter(c => !c.hasActiveContract);
                }
            }

            // 4. FILTRO C: Búsqueda por Texto
            // Se aplica sobre los resultados ya filtrados por los selectores
            if (this.search.length > 0) {
                const term = this.search.toLowerCase();
                results = results.filter(collaborator => {
                    return (
                        (collaborator.name && collaborator.name.toLowerCase().includes(term)) ||
                        (collaborator.first_surname && collaborator.first_surname.toLowerCase().includes(term)) ||
                        (collaborator.second_surname && collaborator.second_surname.toLowerCase().includes(term)) ||
                        (collaborator.document_number && collaborator.document_number.toLowerCase().includes(term)) ||
                        (collaborator.email && collaborator.email.toLowerCase().includes(term)) ||
                        (collaborator.cellphone && collaborator.cellphone.toLowerCase().includes(term)) ||
                        (collaborator.position && collaborator.position.name && collaborator.position.name.toLowerCase().includes(term))
                    );
                });
            }

            // 5. Finalizar actualización de vista
            this.filteredCollaborators = results;
            
            // Activamos la bandera de filtro si CUALQUIERA de los 3 inputs tiene valor
            this.collaboratorsWithFilter = (
                this.search.length > 0 || 
                this.statusFilter !== 'all' || 
                this.contractFilter !== 'all'
            );

            this.getTotalPages(results);
            this.getPageData(1);
        },
        getTotalPages(data) {
            this.totalPages = Math.ceil(data.length / this.collaboratorsPerPage)
        },
        getPageData(page) {
            this.paginatedData = [];
            let start = (page * this.collaboratorsPerPage) - this.collaboratorsPerPage;
            let end = (page * this.collaboratorsPerPage);

            // Utiliza los colaboradores filtrados si hay una búsqueda activa, de lo contrario usa todos los colaboradores
            const data = this.collaboratorsWithFilter ? this.filteredCollaborators : this.collaborators;

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
            const data = this.collaboratorsWithFilter ? this.filteredCollaborators : this.collaborators;
            if (this.currentPage < Math.ceil(data.length / this.collaboratorsPerPage)) {
                this.currentPage++;
            }
            this.getPageData(this.currentPage);
        },
        showCollaboratorContract(collaborator){
            this.selected_collaborator = this.collaborators.find(c => c.id === collaborator)
            this.viewState = 'contract';
        },
        showCollaboratorSocialSecurity(collaborator){
            this.selected_collaborator = this.collaborators.find(c => c.id === collaborator)
            this.viewState = 'social';
        },
        showCollaboratorAbsence(collaborator){
            this.selected_collaborator = this.collaborators.find(c => c.id === collaborator)
            this.viewState = 'absence';
        },
        getCollaborator(collaborator){
            this.selected_collaborator = this.collaborators.find(c => c.id === collaborator)
            this.viewState = 'detail';

            axios.get(`/collaborators/${collaborator}/show`).then(
                (res) => {
                    this.collaboratorData = res.data
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        addCollaborator(){
            this.selected_collaborator = null
            this.viewState = 'add';

            axios.get(`/collaborators-data`).then(
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
        editCollaborator(collaborator){
            this.selected_collaborator = this.collaborators.find(c => c.id === collaborator)
            this.viewState = 'edit';

            axios.get(`/collaborators/${collaborator}/edit`).then(
                (res) => {
                    this.collaboratorDataEdit = res.data
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        deleteCollaborator(id){
            this.is_loading = true; // ACTIVAR
            let url = ''
            axios.delete(`/collaborators/${id}/destroy`).then(
                (res) => {
                    localStorage.setItem('origin', 'deleted');
                    url = `/collaborators`
                    window.location.href = url
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false; // DESACTIVAR
                })
        },
        deactivateCollaborator(id) {
            axios.put(`/collaborators/${id}/deactivate`).then(
                (res) => {
                    localStorage.setItem('origin', 'deactivate');
                    // Nota: Aquí llamas a this.collaborators = this.getCollaborators(),
                    // pero getCollaborators no retorna nada (es void), actualiza el estado internamente.
                    // Lo correcto es simplemente llamar a la función:
                    this.getCollaborators();

                    let url = `/collaborators`
                    // window.location.href = url
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        activateCollaborator(id) {
            axios.put(`/collaborators/${id}/activate`).then(
                (res) => {
                    localStorage.setItem('origin', 'activate');

                    // Mismo caso que arriba, solo llamar a la función
                    this.getCollaborators();

                    let url = `/collaborators`
                    // window.location.href = url
                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        hasCurrentContract(id) {
            return this.collaborators.some(c => c.id === id && c.current_contract);
        }
    },
}
</script>

<style scoped>
    @import './../../assets/css/custom.css';

.portada {
    flex-shrink: 0;
    width: 110px;
    height: 100%;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
    background: linear-gradient(270deg, #fff, #bee6fe);

    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 16px 0;
    box-sizing: border-box;
}

.icon-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2px;
    width: 75px;
}

.icon-grid > a {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 5px;
    border: 1px dotted #0dacff;
    background-color: white;

    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: 0.3s ease;
}

.icon-grid > a:hover {
    background-color: #eef8ff;
    transform: scale(1.05);
}

.icon-grid > a > i {
    font-size: 20px;
    color: #127cb3;
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
