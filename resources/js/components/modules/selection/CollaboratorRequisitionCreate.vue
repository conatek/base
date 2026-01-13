<template>
    <div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <!-- <h5 class="card-title">Nueva Requisición de Personal</h5>
                <p class="text-muted small">Diligencie la información para solicitar la apertura de un proceso de selección.</p> -->
                
                <form @submit.prevent="store" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">Detalles de la Vacante</div>
                                <div class="card-body">
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
                                                <!-- <small class="text-muted">Ej: 3 para tres vacantes del mismo cargo.</small> -->
                                                <div v-if="errors.vacancies_count" class="invalid-feedback">{{ errors.vacancies_count[0] }}</div>
                                            </div>
                                        </div>
        
                                        <!-- <div class="col-md-3">
                                            <div class="position-relative mb-3">
                                                <label for="request_date" class="form-label">Fecha Solicitud <span class="text-danger">*</span></label>
                                                <input v-model="form.request_date" type="date" class="form-control" :class="{'is-invalid': errors.request_date}">
                                                <div v-if="errors.request_date" class="invalid-feedback">{{ errors.request_date[0] }}</div>
                                            </div>
                                        </div> -->
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
                                                    <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.name }}</option>
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
                                                    <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.name }}</option>
                                                </select>
                                                <div v-if="errors.position_id" class="invalid-feedback">{{ errors.position_id[0] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">Justificación</div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="position-relative mb-3">
                                                <label class="form-label">Solicitado por <span class="text-danger">*</span></label>
                                                <select v-model="form.requested_by_id" class="form-control" :class="{'is-invalid': errors.requested_by_id}">
                                                    <option value="" disabled selected>Seleccionar...</option>
                                                    <option v-for="collab in collaborators" :key="collab.id" :value="collab.id">
                                                        {{ collab.name }} {{ collab.first_surname }} {{ collab.second_surname }}
                                                    </option>
                                                </select>
                                                <div v-if="errors.requested_by_id" class="invalid-feedback">{{ errors.requested_by_id[0] }}</div>
                                            </div>
                                        </div> -->
        
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
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fa fa-paper-plane me-2"></i> Enviar Solicitud
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

export default {
    name: 'CollaboratorRequisitionCreate',
    props: {
        requisition_types: { default: () => [] },
        collaborators: { default: () => [] },
        campuses: { default: () => [] },
        areas: { default: () => [] },
        positions: { default: () => [] },
        reasons: { default: () => [] },
    },
    data() {
        return {
            isLoading: false,
            errors: {},
            form: {
                requisition_type_id: '',
                vacancies_count: 1,
                campus_id: '',
                area_id: '',
                position_id: '',
                vacancy_reason_id: '',
                replaces_id: null,
                observations: ''
            }
        };
    },
    computed: {
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
    methods: {
        async store() {
            // Limpieza preventiva
            if (!this.isReplacementReason) this.form.replaces_id = null;
            
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
                
                // Opcional: Redirigir o emitir evento de éxito al padre para refrescar listas
                // this.$emit('created'); 

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

        resetForm() {
            this.form = {
                requisition_type_id: '',
                vacancies_count: 1,
                campus_id: '',
                area_id: '',
                position_id: '',
                vacancy_reason_id: '',
                replaces_id: null,
                observations: ''
            };
            this.errors = {};
        }
    },
    watch: {
        // Resetear selectores dependientes para evitar datos inconsistentes
        'form.campus_id'() { this.form.area_id = ''; this.form.position_id = ''; },
        'form.area_id'() { this.form.position_id = ''; }
    }
};
</script>

<style scoped>
/* Spinner simple por si bootstrap no lo carga */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}
</style>