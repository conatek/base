<template>
    <div>
        <button @click="createRequisition" v-if="!showForm" class="btn btn-primary mb-3">
            <i class="fa fa-plus me-2"></i> Agregar
        </button>

        <div class="main-card mb-3 card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-header-title">Gestión de Requisiciones</div>
                    </div>
                    <!-- <button @click="createRequisition" v-if="!showForm" class="btn btn-primary">
                        <i class="fa fa-plus-circle me-2"></i> Nueva Requisición
                    </button> -->
                </div>
            </div>
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
                    style-class="vgt-table bordered condensed table-hover"
                    no-data-message="No hay resultados que coincidan"
                >
                    <template #table-row="props">
                        <span v-if="props.column.field === 'actions'">
                            <button @click="showRequisition(props.row)"
                                    type="button"
                                    class="btn btn-sm btn-warning me-1 btn-action"
                                    data-bs-toggle="modal" data-bs-target=".requisition-detail-modal"
                                    title="Ver Detalle">
                                <i class="fa fa-eye"></i>
                            </button>

                            <template v-if="props.row.vacancy_status_id === 5">
                                <button @click="editRequisition(props.row)"
                                        type="button"
                                        class="btn btn-sm btn-info me-1 text-white btn-action"
                                        title="Editar">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button @click="approveRequisition(props.row)"
                                        type="button"
                                        class="btn btn-sm btn-success me-1 btn-action"
                                        title="Aprobar">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button @click="cancelRequisition(props.row)"
                                        type="button"
                                        class="btn btn-sm btn-danger btn-action"
                                        title="Cancelar">
                                    <i class="fa fa-times"></i>
                                </button>
                            </template>
                        </span>

                        </template>
                </vue-good-table>
            </div>

            <Teleport to="body">

                <div class="modal fade requisition-detail-modal"
                     tabindex="-1"
                     role="dialog"
                     aria-labelledby="requisitionModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requisitionModalLabel">Detalle de Requisición</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div v-if="selected_requisition">

                                    <div class="data-grid">
                                        <!-- <div class="label">ID:</div>
                                        <div class="value">{{ selected_requisition.id }}</div> -->

                                        <div class="label">Fecha Solicitud:</div>
                                        <div class="value">{{ selected_requisition.request_date }}</div>

                                        <div class="label">Estado:</div>
                                        <div class="value">
                                            <span class="badge"
                                                :class="{
                                                    'bg-success': selected_requisition.vacancy_status_id === 1,
                                                    'bg-info text-dark': selected_requisition.vacancy_status_id === 2,
                                                    'bg-secondary': selected_requisition.vacancy_status_id === 3,
                                                    'bg-danger': selected_requisition.vacancy_status_id === 4,
                                                    'bg-warning text-dark': selected_requisition.vacancy_status_id === 5
                                                }">
                                                {{ selected_requisition.vacancy_status?.name }}
                                            </span>
                                        </div>

                                        <div class="label">Cargo Solicitado:</div>
                                        <div class="value">{{ selected_requisition.position?.name }}</div>

                                        <div class="label">Área:</div>
                                        <div class="value">{{ selected_requisition.area?.name }}</div>

                                        <div class="label">Solicitado por:</div>
                                        <div class="value">{{ selected_requisition.requested_by?.name }} {{ selected_requisition.requested_by?.first_surname }}</div>

                                        <div class="label">Tipo Requisición:</div>
                                        <div class="value">{{ selected_requisition.requisition_type?.name }}</div>

                                        <div class="label">Motivo Vacante:</div>
                                        <div class="value">{{ selected_requisition.vacancy_reason?.name }}</div>

                                        <div class="label">Cantidad Vacantes:</div>
                                        <div class="value">{{ selected_requisition.vacancies_count }}</div>

                                        <div class="label">Reemplaza a:</div>
                                        <div class="value">
                                            {{ selected_requisition.replaces ? (selected_requisition.replaces.name + ' ' + selected_requisition.replaces.first_surname) : 'N/A (Nueva vacante o sin datos)' }}
                                        </div>

                                        <div class="label">Observaciones:</div>
                                        <div class="value">{{ selected_requisition.observations || 'Sin observaciones' }}</div>
                                    </div>

                                    <div v-if="selected_requisition.approved_by" class="mt-4">
                                        <div class="alert alert-success border-success" role="alert">
                                            <h6 class="alert-heading fw-bold mb-3">
                                                <i class="fa fa-check-circle me-2"></i>Detalle de Aprobación
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Aprobado por:</small>
                                                    <span class="fw-bold text-dark">
                                                        {{ selected_requisition.approved_by.name }} {{ selected_requisition.approved_by.first_surname }}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Fecha:</small>
                                                    <span class="fw-bold text-dark">{{ selected_requisition.approved_at }}</span>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted d-block">Comentarios:</small>
                                                    <div class="p-2 bg-white rounded border border-success-subtle text-dark">
                                                        {{ selected_requisition.approval_reason || 'Sin comentarios adicionales.' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selected_requisition.cancelled_by" class="mt-4">
                                        <div class="alert alert-danger border-danger" role="alert">
                                            <h6 class="alert-heading fw-bold mb-3">
                                                <i class="fa fa-ban me-2"></i>Detalle de Cancelación
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Cancelado por:</small>
                                                    <span class="fw-bold text-dark">
                                                        {{ selected_requisition.cancelled_by.name }} {{ selected_requisition.cancelled_by.first_surname }}
                                                    </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted d-block">Fecha:</small>
                                                    <span class="fw-bold text-dark">{{ selected_requisition.cancelled_at }}</span>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted d-block">Motivo de cancelación:</small>
                                                    <div class="p-2 bg-white rounded border border-danger-subtle text-dark">
                                                        {{ selected_requisition.cancellation_reason }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </Teleport>

        </div>
        <div v-if="showForm" id="requisition-form-card" class="main-card mb-3 card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="card-header-title">
                            {{ isEditing ? 'Editar Requisición' : 'Agregar Requisición' }}
                        </div>
                    </div>
                    <!-- <div v-if="isEditing">
                        <button type="button" class="btn btn-sm btn-secondary" @click="resetForm">
                            <i class="fa fa-times"></i> Cancelar Edición
                        </button>
                    </div> -->
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="submitHandler" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="requisition_type_id" class="form-label">Tipo de requisición <span class="text-danger">*</span></label>
                                        <select v-model="form.requisition_type_id" class="form-control" :class="{'is-invalid': errors.requisition_type_id}">
                                            <option value="" disabled selected>Seleccionar...</option>
                                            <option v-for="type in requisition_types" :key="type.id" :value="type.id">{{ type.name }}</option>
                                        </select>
                                        <div v-if="errors.requisition_type_id" class="invalid-feedback">{{ errors.requisition_type_id[0] }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label for="vacancies_count" class="form-label">Cantidad de Vacantes <span class="text-danger">*</span></label>
                                        <input v-model="form.vacancies_count" type="number" min="1" class="form-control" :class="{'is-invalid': errors.vacancies_count}">
                                        <div v-if="errors.vacancies_count" class="invalid-feedback">{{ errors.vacancies_count[0] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label class="form-label">Sede <span class="text-danger">*</span></label>
                                        <select v-model="form.campus_id" class="form-control" :class="{'is-invalid': errors.campus_id}">
                                            <option value="" disabled selected>Seleccionar Sede</option>
                                            <option v-for="campus in campuses" :key="campus.id" :value="campus.id">{{ campus.name }}</option>
                                        </select>
                                        <div v-if="errors.campus_id" class="invalid-feedback">{{ errors.campus_id[0] }}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="position-relative mb-3">
                                        <label class="form-label">Área <span class="text-danger">*</span></label>
                                        <select v-model="form.area_id" class="form-control" :disabled="!form.campus_id" :class="{'is-invalid': errors.area_id}">
                                            <option value="" disabled selected>Seleccionar Área</option>
                                            <option v-for="area in filteredAreas" :key="area.id" :value="area.id">{{ area.name }}</option>
                                        </select>
                                        <div v-if="errors.area_id" class="invalid-feedback">{{ errors.area_id[0] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="position-relative mb-3">
                                        <label class="form-label">Cargo Solicitado <span class="text-danger">*</span></label>
                                        <select v-model="form.position_id" class="form-control" :disabled="!form.area_id" :class="{'is-invalid': errors.position_id}">
                                            <option value="" disabled selected>Seleccionar Cargo</option>
                                            <option v-for="position in filteredPositions" :key="position.id" :value="position.id">{{ position.name }}</option>
                                        </select>
                                        <div v-if="errors.position_id" class="invalid-feedback">{{ errors.position_id[0] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="position-relative mb-3">
                                        <label class="form-label">Motivo de la Vacante <span class="text-danger">*</span></label>
                                        <select v-model="form.vacancy_reason_id" class="form-control" :class="{'is-invalid': errors.vacancy_reason_id}">
                                            <option value="" disabled selected>Seleccionar Motivo</option>
                                            <option v-for="reason in reasons" :key="reason.id" :value="reason.id">{{ reason.name }}</option>
                                        </select>
                                        <div v-if="errors.vacancy_reason_id" class="invalid-feedback">{{ errors.vacancy_reason_id[0] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" v-if="isReplacementReason">
                                <div class="col-12">
                                    <div class="alert alert-info fade show" role="alert">
                                        <i class="fa fa-info-circle"></i> Indique qué colaborador dejó el cargo vacante.
                                    </div>
                                    <div class="position-relative mb-3">
                                        <label class="form-label">¿A quién reemplaza? <span class="text-danger">*</span></label>
                                        <select v-model="form.replaces_id" class="form-control" :class="{'is-invalid': errors.replaces_id}">
                                            <option value="" disabled selected>Seleccionar Colaborador Saliente</option>
                                            <option v-for="collab in collaborators" :key="collab.id" :value="collab.id">
                                                {{ collab.name }} {{ collab.first_surname }} {{ collab.second_surname }}
                                            </option>
                                        </select>
                                        <div v-if="errors.replaces_id" class="invalid-feedback">{{ errors.replaces_id[0] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="position-relative mb-3">
                                        <label class="form-label">Observaciones / Perfil Deseado</label>
                                        <textarea v-model="form.observations" class="form-control" rows="4"
                                            placeholder="Describa detalles adicionales sobre el perfil, urgencia o características especiales del requerimiento..."></textarea>
                                        <div v-if="errors.observations" class="invalid-feedback">{{ errors.observations[0] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fa fa-paper-plane me-2"></i> Enviar Solicitud
                        </button>
                    </div> -->

                    <!-- <div v-if="isEditing">
                        <button type="button" class="btn btn-sm btn-secondary" @click="resetForm">
                            <i class="fa fa-times"></i> Cancelar Edición
                        </button>
                    </div> -->

                    <div class="d-flex justify-content-end gap-2">
                        <!-- <button v-if="isEditing" type="button" class="btn btn-sm btn-secondary" @click="resetForm"> -->
                        <!-- <button type="button" class="btn btn-sm btn-secondary" @click="resetForm"> -->
                        <button type="button" class="btn btn-sm btn-secondary" @click="cancelForm">
                            <!-- <i class="fa fa-times"></i>  -->
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-lg" :class="isEditing ? 'btn-warning text-dark' : 'btn-primary'">
                            <!-- <i class="fa" :class="isEditing ? 'fa-save' : 'fa-paper-plane'"></i> -->
                            {{ isEditing ? 'Actualizar Solicitud' : 'Enviar Solicitud' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { VueGoodTable } from 'vue-good-table-next';

export default {
    name: 'RequisitionIndex',
    components: {
        VueGoodTable
    },
    data() {
        return {
            isLoading: false,
            showForm: false,

            requisition_types: [],
            collaborators: [],
            campuses: [],
            areas: [],
            positions: [],
            reasons: [],
            isEditing: false,
            editingId: null,
            errors: {},
            form: {
                requisition_type_id: '',
                vacancies_count: 1,
                campus_id: '',
                area_id: '',
                position_id: '',
                vacancy_reason_id: '',
                replaces_id: '',
                observations: ''
            },
            columns: [],
            rows: [],
            requisitions: [],
            selected_requisition: null,
        }
    },
    computed: {
        filteredAreas() {
            if (!this.form.campus_id) return [];
            return this.areas.filter(area => area.campus_id === this.form.campus_id);
        },
        filteredPositions() {
            if (!this.form.area_id) return [];
            return this.positions.filter(pos => pos.area_id === this.form.area_id);
        },
        isReplacementReason() {
            if (!this.form.vacancy_reason_id) return false;
            const selectedReason = this.reasons.find(r => r.id === this.form.vacancy_reason_id);
            return selectedReason && (
                selectedReason.name.toLowerCase().includes('reemplazo') ||
                selectedReason.name.toLowerCase().includes('retiro') ||
                selectedReason.name.toLowerCase().includes('sustitución')
            );
        }
    },
    watch: {
        requisitions: {
            handler(newVal) {
                this.rows = newVal;
            },
            deep: true
        }
    },
    mounted() {
        this.fetchFormData();
        this.getRequisitions();
        this.columns = [
            {
                label: 'Fecha',
                field: 'request_date',
                type: 'date',
                dateInputFormat: 'yyyy-MM-dd',
                dateOutputFormat: 'yyyy-MM-dd',
                thClass: 'text-start',
                tdClass: 'text-start'
            },
            {
                label: 'Cargo',
                field: 'position.name',
                thClass: 'text-start',
                tdClass: 'text-start'
            },
            {
                label: 'Área',
                field: 'area.name',
                thClass: 'text-start',
                tdClass: 'text-start'
            },
            {
                label: 'Vacantes',
                field: 'vacancies_count',
                type: 'number',
                thClass: 'text-center',
                tdClass: 'text-center'
            },
            {
                label: 'Estado',
                field: 'vacancy_status.name',
                thClass: 'text-start',
                tdClass: 'text-start'
            },
            {
                label: 'Acciones',
                field: 'actions',
                sortable: false,
                thClass: 'text-end',
                tdClass: 'text-end'
            },
        ];

        if(this.requisitions) {
            this.rows = this.requisitions;
        }
    },
    methods: {
        fetchFormData() {
            axios.get('/modules/selection').then((res) => {
                this.requisition_types = res.data.requisition_types;
                this.collaborators     = res.data.collaborators;
                this.campuses          = res.data.campuses;
                this.areas             = res.data.areas;
                this.positions         = res.data.positions;
                this.reasons           = res.data.reasons;
            }).catch(() => {
                console.error('Error al cargar datos del formulario de selección');
            });
        },
        showRequisition(requisition) {
            this.selected_requisition = requisition;

            // Truco para asegurar que el modal se vea por encima de todo si hay problemas de z-index
            // const modal = document.querySelector('.requisition-detail-modal');
            // if(modal) {
            //     document.body.appendChild(modal);
            //     // modal.style.zIndex = '1055'; // Opcional para problemas de capas
            // }
        },
        getRequisitions() {
            axios.get('/selection/collaborator-requisitions')
                .then(response => {
                    this.requisitions = response.data;
                    this.rows = response.data; // Actualizamos las filas de la tabla
                })
                .catch(error => {
                    console.error('Error al cargar requisiciones:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar datos',
                        text: 'No se pudieron cargar las requisiciones. Por favor, intenta nuevamente.'
                    });
                });
        },
        async store() {
            // Limpieza preventiva
            if (!this.isReplacementReason) this.form.replaces_id = '';

            this.isLoading = true;
            this.errors = {}; // Limpiar errores previos

            try {
                const response = await axios.post('/selection/collaborator-requisitions', this.form);

                // ÉXITO

                // Opción 1: SweetAlert (Recomendado)
                Swal.fire({
                    icon: 'success',
                    title: '¡Solicitud Enviada!',
                    text: 'La requisición ha sido creada y notificada a los aprobadores.',
                    confirmButtonColor: '#127cb3'
                });

                // Opción 2: Alerta simple
                // alert('Solicitud creada con éxito');

                this.resetForm();
                this.showForm = false;

                // Opcional: Redirigir o emitir evento de éxito al padre para refrescar listas
                // this.$emit('created');

                this.getRequisitions(); // Refrescar la lista de requisiciones para mostrar la nueva entrada

            } catch (error) {
                // ERROR
                if (error.response && error.response.status === 422) {
                    // Errores de validación de Laravel (Unprocessable Entity)
                    this.errors = error.response.data.errors;

                    Swal.fire({
                        icon: 'error',
                        title: 'Datos incompletos',
                        text: 'Por favor revisa el formulario, hay campos obligatorios pendientes.'
                    });
                } else {
                    // Otros errores (500, etc)
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'Ocurrió un error inesperado al procesar la solicitud.'
                    });
                }
            } finally {
                this.isLoading = false;
            }
        },
        // 1. MÉTODO PARA INICIAR CREACIÓN
        createRequisition() {
            this.resetForm(); // Limpia datos previos
            this.isEditing = false;
            this.showForm = true; // Muestra el formulario
            this.scrollToForm();  // Baja la pantalla
        },

        // 2. MÉTODO ACTUALIZADO PARA EDICIÓN
        editRequisition(row) {
            this.errors = {}; // Limpiar errores
            this.isEditing = true;
            this.editingId = row.id;

            // Llenar datos
            this.form = {
                requisition_type_id: row.requisition_type_id,
                vacancies_count: row.vacancies_count,
                campus_id: row.area.campus_id,
                area_id: row.area_id,
                position_id: row.position_id,
                vacancy_reason_id: row.vacancy_reason_id,
                replaces_id: row.replaces_id,
                observations: row.observations
            };

            this.showForm = true; // Asegura que se vea
            this.scrollToForm();  // Baja la pantalla
        },

        // 3. MÉTODO PARA CANCELAR/OCULTAR
        cancelForm() {
            this.showForm = false; // Oculta el formulario
            this.resetForm();      // Limpia todo

            // Opcional: Hacer scroll hacia arriba (a la tabla)
            this.$nextTick(() => {
                document.querySelector('.main-card').scrollIntoView({ behavior: 'smooth' });
            });
        },

        // 4. UTILIDAD DE SCROLL
        scrollToForm() {
            // Usamos nextTick para esperar a que Vue renderice el v-if="showForm"
            this.$nextTick(() => {
                const formElement = document.getElementById('requisition-form-card');
                if (formElement) {
                    formElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        },

        // NUEVO MÉTODO: Update (Put)
        async update() {
             // Limpieza preventiva
             if (!this.isReplacementReason) this.form.replaces_id = '';

            this.isLoading = true;
            this.errors = {};

            try {
                const response = await axios.put(`/selection/collaborator-requisitions/${this.editingId}`, this.form);

                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'La requisición ha sido modificada correctamente.',
                    confirmButtonColor: '#127cb3',
                    timer: 2000
                });

                this.resetForm(); // Esto reseteará isEditing a false
                this.showForm = false;

                this.getRequisitions();

            } catch (error) {
                // Manejo de errores idéntico al store
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors;
                    Swal.fire({ icon: 'error', title: 'Datos incompletos', text: 'Por favor revisa el formulario.' });
                } else {
                    console.error(error);
                    Swal.fire({ icon: 'error', title: 'Error', text: error.response?.data?.message || 'Error del servidor.' });
                }
            } finally {
                this.isLoading = false;
            }
        },
        submitHandler() {
            if (this.isEditing) {
                this.update();
            } else {
                this.store();
            }
        },
        async approveRequisition(requisition) {
            const { value: observation } = await Swal.fire({
                title: '¿Aprobar Requisición?',
                text: `Se aprobará la vacante para el cargo: ${requisition.position.name}`,
                icon: 'question',
                input: 'textarea',
                inputLabel: 'Comentarios de aprobación (Opcional)',
                inputPlaceholder: 'Escribe aquí tus observaciones...',
                showCancelButton: true,
                confirmButtonColor: '#127cb3',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Aprobar',
                cancelButtonText: 'Cancelar',
                // CORRECCIÓN DEFINITIVA:
                // Usamos didOpen para ajustar el ancho exacto del input y centrarlo.
                // Esto evita el desbordamiento (overflow) y asegura el margen visual.
                didOpen: () => {
                    const input = Swal.getInput();
                    if (input) {
                        input.style.width = '90%';      // Reduce el ancho para dejar espacio
                        input.style.margin = '1em auto'; // Centra el elemento y da aire arriba/abajo
                    }
                }
            });

            if (observation !== undefined) {
                this.processStatusChange(requisition.id, 'approve', observation);
            }
        },

        async cancelRequisition(requisition) {
            const { value: observation } = await Swal.fire({
                title: '¿Cancelar Requisición?',
                text: "Esta acción cambiará el estado a Cancelada y no se podrá gestionar.",
                icon: 'warning',
                input: 'textarea',
                inputLabel: 'Motivo de cancelación (Obligatorio)',
                inputPlaceholder: 'Indica por qué se cancela la solicitud...',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debes escribir un motivo para cancelar.';
                    }
                },
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, Cancelar',
                cancelButtonText: 'Volver',
                // CORRECCIÓN DEFINITIVA:
                didOpen: () => {
                    const input = Swal.getInput();
                    if (input) {
                        input.style.width = '90%';
                        input.style.margin = '1em auto';
                    }
                }
            });

            if (observation) {
                this.processStatusChange(requisition.id, 'cancel', observation);
            }
        },
        async processStatusChange(id, action, observation) {
            this.isLoading = true; // Puedes poner un loading global o local
            try {
                // action será 'approve' o 'cancel' según el método que llame
                const response = await axios.put(`/requisitions/${id}/${action}`, {
                    observation: observation
                });

                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Procesado!',
                        text: response.data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    this.getRequisitions(); // Recargar la tabla
                }
            } catch (error) {
                console.error(`Error al procesar ${action}:`, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'No se pudo procesar la solicitud.'
                });
            } finally {
                this.isLoading = false;
            }
        },
        resetForm() {
            this.isEditing = false; // <--- Resetear estado
            this.editingId = null;  // <--- Resetear ID
            this.form = {
                requisition_type_id: '',
                vacancies_count: 1,
                campus_id: '',
                area_id: '',
                position_id: '',
                vacancy_reason_id: '',
                replaces_id: '',
                observations: ''
            };
            this.errors = {};
        }
    },
}
</script>

<style scoped>
/* Estilos copiados y adaptados de tu referencia */
.data-grid {
    display: grid;
    grid-template-columns: 35% 65%; /* Ajustado ligeramente para etiquetas largas */
    gap: 10px;
    font-family: Arial, sans-serif;
    font-size: 14px;
    margin: 10px;
    align-items: center;
}

.label {
    font-weight: bold;
    text-align: left;
    padding-right: 10px;
    color: #495057;
}

/* .value {
    text-align: left;
    color: #333;
    background-color: #f9f9f9;
    border: 1px dotted #ccc;
    padding: 6px 10px;
    border-radius: 4px;
    word-break: break-word;
} */

/* .value {
    text-align: left;
    color: #333;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
    padding: 6px 10px;
    border-radius: 4px;
    word-break: break-word;
} */

.value {
    text-align: left;
    color: #333;
    background-color: #ffffff; /* Antes era #f9f9f9 */
    border: 1px solid #dee2e6; /* Borde suave estilo Bootstrap */
    padding: 6px 10px;
    border-radius: 4px;
    word-break: break-word;
}

/* Ajustes adicionales para la tabla */
.vgt-table {
    font-size: 0.9rem;
}

/* Spinner simple por si bootstrap no lo carga */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}

.modal-body {
    /* Define una altura máxima relativa a la pantalla del dispositivo */
    max-height: 100vh;

    /* Activa el scroll vertical si el contenido excede esa altura */
    overflow-y: auto;

    /* Opcional: Asegura que el fondo sea blanco por si acaso */
    background-color: #ffffff;
}

/* Clase personalizada para botones de acción cuadrados */
.btn-action {
    width: 35px;
    height: 35px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    vertical-align: middle;
}

/* Opcional: Ajustar tamaño del icono si se ve descentrado */
.btn-action i {
    font-size: 12px;
    margin: 0;
}
</style>
