<template>
    <div>
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
                                                <label for="requisition_type_id" class="form-label">Tipo de requisición*</label>
                                                <select v-model="requisition_type_id" name="requisition_type_id" class="form-control"  id="requisition_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Requisición</option>
                                                    <option v-for="requisition_type in requisition_types" :value="requisition_type.id">{{ requisition_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.requisition_type_id" class="error text-danger" for="requisition_type_id">{{ errors.requisition_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="request_date" class="form-label">Fecha de Solicitud*</label>
                                                <input v-model="request_date" name="request_date" id="request_date" type="date" class="form-control" placeholder="Ingrese fecha solicitud">
                                                <span v-if="errors && errors.request_date" class="error text-danger" for="request_date">{{ errors.request_date[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="requested_by_id" class="form-label">Solicitado por*</label>
                                                <select v-model="requested_by_id" name="requested_by_id" class="form-control"  id="requested_by_id">
                                                    <option value="" disabled selected hidden>Seleccionar Solicitante</option>
                                                    <option v-for="collaborator in collaborators" :value="collaborator.id">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</option>
                                                </select>
                                                <span v-if="errors && errors.requested_by_id" class="error text-danger" for="requested_by_id">{{ errors.requested_by_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="reason_id" class="form-label">Razon de Vacante*</label>
                                                <select v-model="reason_id" name="reason_id" class="form-control"  id="reason_id">
                                                    <option value="" disabled selected hidden>Seleccionar Razón Vacante</option>
                                                    <option v-for="reason in reasons" :value="reason.id">{{ reason.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.reason_id" class="error text-danger" for="reason_id">{{ errors.reason_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="replaces_id" class="form-label">A quién reemplaza*</label>
                                                <select v-model="replaces_id" name="replaces_id" class="form-control"  id="replaces_id">
                                                    <option value="" disabled selected hidden>Seleccionar Saliente</option>
                                                    <option v-for="collaborator in collaborators" :value="collaborator.id">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</option>
                                                </select>
                                                <span v-if="errors && errors.replaces_id" class="error text-danger" for="replaces_id">{{ errors.replaces_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="campus_id" class="form-label">Sede*</label>
                                                <select v-model="campus_id" name="campus_id" class="form-control"  id="campus_id">
                                                    <option value="" disabled selected hidden>Seleccionar Sede</option>
                                                    <option v-for="campus in campuses" :value="campus.id">{{ campus.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.campus_id" class="error text-danger" for="campus_id">{{ errors.campus_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="area_id" class="form-label">Area*</label>
                                                <select v-model="area_id" name="area_id" class="form-control"  id="area_id" :disabled="campus_id == ''">
                                                    <option value="" disabled selected hidden>Seleccionar Área</option>
                                                    <option v-for="area in areas" :value="area.id">{{ area.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.area_id" class="error text-danger" for="area_id">{{ errors.area_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="position_id" class="form-label">Cargo*</label>
                                                <select v-model="position_id" class="form-control" name="position_id" id="position_id" :disabled="area_id == ''">
                                                    <option value="" disabled selected hidden>Seleccionar Cargo</option>
                                                    <option v-for="position in positions" :value="position.id">{{ position.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.position_id" class="error text-danger" for="position_id">{{ errors.position_id[0] }}</span>
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
                                    Información de Avance/Cierre
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="status_id" class="form-label">Estado de Vacante*</label>
                                                <select v-model="status_id" name="status_id" class="form-control"  id="status_id">
                                                    <option value="" disabled selected hidden>Seleccionar Estado Vacante</option>
                                                    <option v-for="status in statuses" :value="status.id">{{ status.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.status_id" class="error text-danger" for="status_id">{{ errors.status_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="closing_date" class="form-label">Fecha de Cierre*</label>
                                                <input v-model="closing_date" name="closing_date" id="closing_date" type="date" class="form-control" placeholder="Ingrese fecha de terminación">
                                                <span v-if="errors && errors.closing_date" class="error text-danger" for="closing_date">{{ errors.closing_date[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="vacancy_duration_days" class="form-label">Duración</label>
                                                <input v-model="vacancy_duration_days" name="vacancy_duration_days" id="vacancy_duration_days" type="text" class="form-control" placeholder="Ingrese duración de vacante">
                                                <span v-if="errors && errors.vacancy_duration_days" class="error text-danger" for="vacancy_duration_days">{{ errors.vacancy_duration_days[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="source_id" class="form-label">Fuente*</label>
                                                <select v-model="source_id" name="source_id" class="form-control"  id="source_id">
                                                    <option value="" disabled selected hidden>Seleccionar Fuente</option>
                                                    <option v-for="source in sources" :value="source.id">{{ source.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.source_id" class="error text-danger" for="source_id">{{ errors.source_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="replaces_id" class="form-label">Persona Seleccionada*</label>
                                                <select v-model="replaces_id" name="replaces_id" class="form-control"  id="replaces_id">
                                                    <option value="" disabled selected hidden>Seleccionar Nuevo Colaborador</option>
                                                    <option v-for="collaborator in collaborators" :value="collaborator.id">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</option>
                                                </select>
                                                <span v-if="errors && errors.replaces_id" class="error text-danger" for="replaces_id">{{ errors.replaces_id[0] }}</span>
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
export default {
    name: 'CollaboratorRequisitionCreate',
    props: {
        requisition_types: {
            default: null,
        },
        collaborators: {
            default: null,
        },
        campuses: {
            default: null,
        },
        areas: {
            default: null,
        },
        positions: {
            default: null,
        },
        reasons: {
            default: null,
        },
        statuses: {
            default: null,
        },
        sources: {
            default: null,
        },
    },
    data() {
        return {
            requisition_type_id: '',
            requested_by_id: '',
            campus_id: '',
            area_id: '',
            position_id: '',
            reason_id: '',
            status_id: '',
            replaces_id: '',
            source_id: '',
        };
    },
    mounted() {
        // Código a ejecutar cuando el componente se monta
    },
    methods: {
        // Definir métodos aquí
    },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
