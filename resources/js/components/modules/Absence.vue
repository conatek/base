<template>
    <div class="container-fluid">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <!-- <i class="pe-7s-user text-success"></i> -->
                        <i class="fa fa-clock" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Ausentismo General
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mt-2">
                <button @click="changeView('absence_indicators')" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: absence_indicators }">
                    <i class="fa fa-chart-bar btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Indicadores de Ausentismo
                </button>
            </div>
            <div class="col-md-4 mt-2">
                <button @click="changeView('disability_control')" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: disability_control }">
                    <i class="fa fa-lungs-virus btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Control de Incapacidades
                </button>
            </div>
            <!-- <div class="col-md-4">
                <button @click="changeView('eps_payments')" class="btn-icon-vertical btn-transition btn btn-mh-dark-blue w-100"
                    :class="{ active: eps_payments }">
                    <i class="fa fa-money-bill btn-icon-wrapper"></i>
                    <span class="badge bg-primary badge-dot badge-dot-sm badge-dot-inside"></span>Relaciones de Pago EPS
                </button>
            </div> -->
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4">
                <div v-if="absence_indicators" class="main-card mb-3 card w-100">
                    <div class="card-header">Filtros</div>
                    <div class="card-body">
                        <div class="row d-flex">
                            <div v-if="campuses" class="col-md-6 mb-3">
                                <label for="campus_id" class="form-label">Sede</label>
                                <select v-model="campus_id" @change="changeCampus()" id="campus_id" class="form-select">
                                    <option value="" disabled selected hidden>Seleccionar Sede</option>
                                    <option v-for="campus in campuses" :value="campus.id">{{ campus.name }}</option>
                                </select>
                            </div>
                            <div v-if="areas" class="col-md-6">
                                <label for="area_id" class="form-label">Área</label>
                                <select v-model="area_id" @change="changeArea()" id="area_id" class="form-select">
                                    <option value="" disabled selected hidden>Seleccionar Área</option>
                                    <option v-for="area in areas" :value="area.id">{{ area.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button @click="cleanFilters" class="btn btn-mh-dark-blue">
                            <i class="fa fa-eraser"></i> Limpiar filtros
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="absence_indicators && !disability_control && !eps_payments" class="col-md-8">
                <div class="row">
                    <div v-if="chartAbsenceGeneralData && chartAbsenceGeneralOptions" class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                Días no laborados por mes
                                <div class="btn-actions-pane-right actions-icon-btn">
                                    <select v-model="year" @change="calculateMonthlyAbsences" class="form-select w-auto float-end">
                                        <option v-for="y in generateYears()" :key="y" :value="y">{{ y }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-12">
                                        <Bar
                                            :data="chartAbsenceGeneralData"
                                            :options="chartAbsenceGeneralOptions"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div>
                                        <strong>Total:</strong> {{ Object.values(monthlyAbsences).reduce((a, b) => a + b, 0) }} días
                                    </div>
                                    <div class="ms-3">
                                        <strong>Promedio mensual:</strong> {{ (Object.values(monthlyAbsences).reduce((a, b) => a + b, 0) / 12).toFixed(2) }} días
                                    </div>
                                    <div class="ms-auto">
                                        <button @click="returnToList()" class="btn btn-mh-dark-blue">
                                            <i class="fa fa-plus"></i>
                                            Ver más
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="chartAbsenceTypeData && chartAbsenceTypeOptions" class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                Días no laborados por tipo de contingencia
                                <div class="btn-actions-pane-right actions-icon-btn">
                                    <select v-model="month" @change="calculateAbsencesByType(month, year)" class="form-select w-auto float-end">
                                        <option v-for="(monthName, index) in months" :key="index" :value="index + 1">
                                            {{ monthName }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-12">
                                        <Bar
                                            :data="chartAbsenceTypeData"
                                            :options="chartAbsenceTypeOptions"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="ms-auto">
                                        <button @click="returnToList()" class="btn btn-mh-dark-blue">
                                            <i class="fa fa-plus"></i>
                                            Ver más
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div v-if="chartAbsenceSubtypeData && chartAbsenceSubtypeOptions" class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                Días no laborados por subtipo de contingencia
                                <div class="btn-actions-pane-right actions-icon-btn">
                                    <select v-model="selectedAbsenceType" @change="calculateMonthlyAbsencesByClassification(month, year, selectedAbsenceType.id)" class="form-select w-auto float-end">
                                        <option v-for="absence in absence_types" :key="absence.id" :value="absence">
                                            {{ absence.type }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-12">
                                        <Bar
                                            :data="chartAbsenceSubtypeData"
                                            :options="chartAbsenceSubtypeOptions"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="ms-auto">
                                        <button @click="returnToList()" class="btn btn-mh-dark-blue">
                                            <i class="fa fa-plus"></i>
                                            Ver más
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="chartAbsenceResponsibleData && chartAbsenceResponsibleOptions" class="col-md-6">
                        <div class="main-card mb-3 card">
                            <div class="card-header">
                                Días no laborados por responsabilidad de pago
                            </div>
                            <div class="card-body">
                                <div class="row d-flex">
                                    <div class="col-12">
                                        <Bar
                                            :data="chartAbsenceResponsibleData"
                                            :options="chartAbsenceResponsibleOptions"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <div class="ms-auto">
                                        <button @click="showResponsiblePaymentDetail(chartAbsenceResponsibleData)"
                                            type="button"
                                            class="btn btn-mh-dark-blue"
                                            data-bs-toggle="modal" data-bs-target=".responsible-payment-detail-modal">
                                            <i class="fa fa-plus"></i>
                                            Ver más
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!absence_indicators && disability_control && !eps_payments" class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Incapacidades</div>
                    <div class="card-body table-responsive">
                        <table style="width: 100%;" id="dt_disabilities" class="table table-cntk table-hover table-bordered display">
                            <thead>
                                <tr>
                                    <th class="text-center">Documento</th>
                                    <th class="text-center">Colaborador</th>
                                    <th class="text-center">EPS</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">Duración</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="absenceChain in consolidatedAbsences">
                                    <td class="text-center">{{ numberFormat(absenceChain.document_number) }}</td>
                                    <td class="text-start">{{ absenceChain.name }} <br> {{ absenceChain.first_surname }} {{ absenceChain.second_surname }}</td>
                                    <td class="text-center">{{ absenceChain.eps_name }}</td>
                                    <td class="text-center">{{ absenceChain.absence_type }}</td>

                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-start">
                                            <div class="text-start">
                                                <div class="d-flex">
                                                    <strong class="me-2">Inicio:</strong>
                                                    <span>{{ absenceChain.start_date }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <strong class="me-2">Fin:</strong>
                                                    <span>{{ absenceChain.end_date }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">{{ absenceChain.total_days }} días</td>

                                    <td class="text-end">
                                        <div class="d-flex flex-row align-items-center justify-content-end gap-1">
                                            <!-- <button @click="showPayments(absence)"
                                                    type="button"
                                                    class="btn btn-sm btn-warning"
                                                    style="color: white;">
                                                <i class="fa fa-dollar-sign"></i> Pagos EPS
                                            </button> -->
                                            <button @click="showAbsenceChainDetail(absenceChain)"
                                                    type="button"
                                                    class="btn-icon btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i> Mostrar Cadena
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div v-if="!absence_indicators && disability_control && !eps_payments && show_absence_chain_detail && selected_absence_chain && selected_absence_chain.absences_in_chain && selected_absence_chain.absences_in_chain.length > 0" class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">Detalle de Cadena</div>
                    <div class="card-body table-responsive">
                        <table style="width: 100%;" id="dt_disability_detail" class="table table-cntk table-hover table-bordered display">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Clasificación</th>
                                    <th class="text-center">Inicio</th>
                                    <th class="text-center">Finalización</th>
                                    <th class="text-center">Duración</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="absence in selected_absence_chain.absences_in_chain">
                                    <td class="text-center">{{ absence.id }}</td>
                                    <td class="text-center">{{ absence.disease_classification_code }} - {{ absence.description }}</td>
                                    <td class="text-center">{{ absence.start_date }}</td>
                                    <td class="text-center">{{ absence.end_date }}</td>
                                    <td class="text-center">{{ absence.days }} días</td>
                                    <td class="text-center">
                                        <span class="badge bg-success" style="min-width: 100px;">{{ absence.absence_status.absence_status_type.type }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex flex-row align-items-center justify-content-end gap-1">
                                            <button @click="showDisabilityDetail(absence)"
                                                    type="button"
                                                    class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i> Ver Detalle
                                            </button>
                                            <button @click="editDisability(absence)"
                                                    type="button"
                                                    class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- <div v-if="!absence_indicators && !disability_control && eps_payments" class="col-md-12">
                <p>Relación de Pagos EPS</p>
            </div> -->
        </div>

        <div class="modal fade responsible-payment-detail-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Responsable de Pago</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- <div v-if="selected_absence" class="data-grid"> -->
                        <div class="data-grid">
                            <div class="label">Empresa:</div>
                            <div class="value">{{ chartAbsenceResponsibleData ? chartAbsenceResponsibleData.datasets[0].data[0] : '' }} días al 100%</div>

                            <div class="label">EPS:</div>
                            <div class="value">{{ chartAbsenceResponsibleData ? chartAbsenceResponsibleData.datasets[0].data[1] : '' }} días al 67%</div>

                            <div class="label">ARL:</div>
                            <div class="value">{{ chartAbsenceResponsibleData ? chartAbsenceResponsibleData.datasets[0].data[2] : '' }} días al 100%</div>
                        </div>

                        <hr>

                        <div class="data-grid">
                            <div class="label">Total Empresa:</div>
                            <div class="value">
                                {{ monthlyPaymentsByResponsible && monthlyPaymentsByResponsible.company >= 0
                                    ? `$ ${numberFormat(monthlyPaymentsByResponsible.company)}`
                                    : 'Faltan datos para realizar el cálculo' }}
                            </div>

                            <div class="label">Total EPS:</div>
                            <div class="value">
                                {{ monthlyPaymentsByResponsible && monthlyPaymentsByResponsible.eps >= 0
                                    ? `$ ${numberFormat(monthlyPaymentsByResponsible.eps)}`
                                    : 'Faltan datos para realizar el cálculo' }}
                            </div>

                            <div class="label">Total ARL:</div>
                            <div class="value">
                                {{ monthlyPaymentsByResponsible && monthlyPaymentsByResponsible.arl >= 0
                                    ? `$ ${numberFormat(monthlyPaymentsByResponsible.arl)}`
                                    : 'Faltan datos para realizar el cálculo' }}
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade absence-chain-detail-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle de Incapacidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="selected_absence_chain" class="data-grid">
                            <div class="label">Colaborador:</div>
                            <div class="value">{{ selected_absence_chain.name }} {{ selected_absence_chain.first_surname }} {{ selected_absence_chain.second_surname }}</div>

                            <div class="label">Número Documento:</div>
                            <div class="value">{{ numberFormat(selected_absence_chain.document_number) }}</div>

                            <div class="label">Tipo de Incapacidad:</div>
                            <div class="value">{{ selected_absence_chain.absence_type }}</div>

                            <div class="label">Fecha de Inicio:</div>
                            <div class="value">{{ selected_absence_chain.start_date }}</div>

                            <div class="label">Fecha de Finalización:</div>
                            <div class="value">{{ selected_absence_chain.end_date }}</div>

                            <div class="label">EPS:</div>
                            <div class="value">{{ selected_absence_chain.eps_name }}</div>

                            <div class="label">Duración:</div>
                            <div class="value">{{ selected_absence_chain.total_days }} días</div>

                            <div class="label">Estado:</div>
                            <div class="value">Rechazada</div>

                            <div class="label">Valor Autorizado:</div>
                            <div class="value">XX</div>

                            <div class="label">Valor Pagado:</div>
                            <div class="value">XX</div>

                            <div class="label">Días Pagados:</div>
                            <div class="value">XX</div>

                            <div class="label">Fecha de Pago:</div>
                            <div class="value">XX</div>

                            <div class="label">Observaciones:</div>
                            <div class="value">XX</div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="modal fade absence-payments-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Pagos EPS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="data-grid">
                            <div class="label">Colaborador:</div>
                            <div class="value">Prueba</div>

                            <div class="label">Colaborador:</div>
                            <div class="value">Prueba</div>
                        </div>

                        <table style="width: 100%;" id="dt_disability_detail" class="table table-cntk table-hover table-bordered display">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Clasificación</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="absence in selected_absence_chain.absences_in_chain">
                                    <td class="text-center">{{ absence.id }}</td>
                                    <td class="text-center">{{ absence.disease_classification_code }} - {{ absence.description }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success" style="min-width: 100px;">{{ absence.absence_status.absence_status_type.type }}</span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex flex-row align-items-center justify-content-end gap-1">
                                            <button @click="showDisabilityDetail(absence)"
                                                    type="button"
                                                    class="btn btn-sm btn-success">
                                                <i class="fa fa-eye"></i> Descargar Soporte
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="updateAbsenceStatus">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="modal fade absence-detail-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle Incapacidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div v-if="selectedAbsence" class="modal-body container">
                    <!-- <div class="modal-body container"> -->
                        <div class="data-grid">
                            <div class="label">ID:</div>
                            <div class="value">{{ selectedAbsence.id }}</div>
                            <!-- <div class="value">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</div> -->

                            <div class="label">Clasificación:</div>
                            <div class="value">{{ selectedAbsence.disease_classification_code }} - {{ selectedAbsence.description }}</div>

                            <div class="label">Fecha de Inicio:</div>
                            <div class="value">{{ selectedAbsence.start_date }}</div>

                            <div class="label">Fecha de Finalización:</div>
                            <div class="value">{{ selectedAbsence.end_date }}</div>

                            <div class="label">Duración:</div>
                            <div class="value">{{ selectedAbsence.days }} días</div>
                        </div>

                        <hr>

                        <div class="data-grid">
                            <div class="label">Estado:</div>
                            <div class="value">{{ selectedAbsence.absence_status.absence_status_type.type }}</div>

                            <div class="label">Valor Autorizado:</div>
                            <div class="value">{{ selectedAbsence.absence_status.authorized_value }}</div>

                            <div class="label">Valor Pagado:</div>
                            <div class="value">{{ selectedAbsence.absence_status.paid_value }}</div>

                            <div class="label">Días Pagados:</div>
                            <div class="value">{{ selectedAbsence.absence_status.paid_days }}</div>

                            <div class="label">Fecha de Pago:</div>
                            <div class="value">{{ selectedAbsence.absence_status.payment_date }}</div>

                            <div class="label">Observaciones:</div>
                            <div class="value">{{ selectedAbsence.absence_status.observations }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            v-if="selectedAbsence && selectedAbsence.absence_status && selectedAbsence.absence_status.support_url"
                            @click="downloadSupportFile(selectedAbsence.id)"
                            type="button"
                            class="btn btn-warning"
                            title="Descargar archivo actual"
                            style="border: 1px solid #ced4da;"
                        >
                            <i class="fa fa-download"></i>
                            Descargar Soporte de Pago
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-primary" @click="updateAbsenceStatus">Guardar Cambios</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selectedAbsence" class="modal fade absence-chain-edit-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Editar Incapacidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="support_file" class="form-label">Soporte de Pago</label>
                                    <div class="input-group">
                                        <input @change="changeSupportFile" ref="support_file" type="file" name="support_file" id="support_file" class="form-control">
                                        <button
                                            v-if="selectedAbsence && selectedAbsence.absence_status && selectedAbsence.absence_status.support_url"
                                            @click="downloadSupportFile(selectedAbsence.id)"
                                            type="button"
                                            class="btn btn-warning"
                                            title="Descargar archivo actual"
                                            style="border: 1px solid #ced4da;"
                                        >
                                            <i class="fa fa-download"></i>
                                        </button>
                                    </div>
                                    <span v-if="errors && errors.support_file" class="error text-danger" for="support_file">{{ errors.support_file[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="status" class="form-label">Estado</label>
                                    <select v-model="absence_status_type_id" name="status" class="form-select"  id="status">
                                        <option value="" disabled selected hidden>Seleccionar Estado</option>
                                        <option v-for="status in absence_status_types" :value="status.id">{{ status.type }}</option>
                                    </select>
                                    <span v-if="errors && errors.status" class="error text-danger" for="status">{{ errors.status[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="authorized_value" class="form-label">Valor Autorizado</label>
                                    <input v-model="authorized_value" name="authorized_value" id="authorized_value" type="text" class="form-control" placeholder="Ingrese valor autorizado">
                                    <span v-if="errors && errors.authorized_value" class="error text-danger" for="authorized_value">{{ errors.authorized_value[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="paid_value" class="form-label">Valor Pagado</label>
                                    <input v-model="paid_value" name="paid_value" id="paid_value" type="text" class="form-control" placeholder="Ingrese valor pagado">
                                    <span v-if="errors && errors.paid_value" class="error text-danger" for="paid_value">{{ errors.paid_value[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="paid_days" class="form-label">Días Pagados</label>
                                    <input v-model="paid_days" name="paid_days" id="paid_days" type="text" class="form-control" placeholder="Ingrese días pagados">
                                    <span v-if="errors && errors.paid_days" class="error text-danger" for="paid_days">{{ errors.paid_days[0] }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="position-relative mb-3">
                                    <label for="payment_date" class="form-label">Fecha de Pago</label>
                                    <input v-model="payment_date" name="payment_date" id="payment_date" type="date" class="form-control" placeholder="Ingrese fecha de pago">
                                    <span v-if="errors && errors.payment_date" class="error text-danger" for="payment_date">{{ errors.payment_date[0] }}</span>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="updateAbsenceStatus">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { cloneDeep } from 'lodash';
import { Bar } from 'vue-chartjs'
import { Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale } from 'chart.js'

import axios from 'axios';
import {
    setAbsenceGeneralData,
    absenceGeneralOptions,
    setAbsenceTypeData,
    absenceTypeOptions,
    setAbsenceSubtypeData ,
    absenceSubtypeOptions,
    setAbsenceResponsibleData,
    absenceResponsibleOptions } from '../../assets/js/dataAbsenceGeneralGraphics.js';

import { disabilitiesDatatable, disabilityDetailDatatable } from '../../assets/js/tables.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale)



export default {
    name: 'Absence',

    components: {
        Bar,
        Doughnut
    },
    props: {
        eps: {
            default: null,
        },
        campuses: {
            default: null,
        },
        absence_types: {
            default: null,
        },
        absence_subtypes: {
            default: null,
        },
        absence_status_types: {
            default: null,
        },
    },
    data() {
        return {
            areas: null,
            area_id: '',
            campus_id: '',
            absence_type_id: '',
            absence_subtype: '',
            absence_subtypes_filtered: [],
            disease_classification_code: '',
            disease_classification: [],
            description: '',

            absences: [],
            filteredAbsences: [],
            absencesForDisability: [],
            consolidatedAbsences: [],
            collaborators: [],

            isLoading: true,

            chartAbsenceGeneralData: null,
            chartAbsenceGeneralOptions: absenceGeneralOptions,

            chartAbsenceTypeData: null,
            chartAbsenceTypeOptions: absenceTypeOptions,

            chartAbsenceSubtypeData: null,
            chartAbsenceSubtypeOptions: absenceSubtypeOptions,

            chartAbsenceResponsibleData: null,
            chartAbsenceResponsibleOptions: absenceResponsibleOptions,

            monthlyAbsences: {},
            absencesByType: {},
            monthlyAbsencesByClassification: {},
            monthlyAbsencesByResponsible: {},
            monthlyPaymentsByResponsible: {},

            year: new Date().getFullYear(),
            month: new Date().getMonth() + 1,
            months: [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ],
            selectedAbsenceType: null,

            absence_indicators: true,
            disability_control: false,
            eps_payments: false,

            selected_absence_chain: null,
            show_absence_chain_detail: false,

            selectedAbsence: null,

            absence_status_id: '',
            absence_status_type_id: '',
            authorized_value: '',
            paid_value: '',
            paid_days: '',
            payment_date: '',
            observations: '',
            support_file: null,

            errors: null,
        };
    },
    mounted() {
        this.getAbsences();
        this.selectedAbsenceType = this.absence_types.find(item => item.id === 1);
    },
    watch: {
        absences: {
            handler(newValue) {
                this.absences = newValue;
                this.filteredAbsences = cloneDeep(this.absences);

                this.$nextTick(() => {
                    disabilitiesDatatable();
                });
            },
            deep: true
        },
        filteredAbsences: {
            handler(newValue) {
                this.filteredAbsences = newValue;
                this.isLoading = false;
                // this.collaborators = [...new Set(this.filteredAbsences.map(a => a.collaborator_id))];
                this.calculateMonthlyAbsences();
                this.absencesForDisability = this.filteredAbsences.filter(absence => [1, 2, 3, 4, 5].includes(absence.absence_type_id));
                this.processAbsenceChains(this.absencesForDisability, this.eps, this.absence_types);
            },
            deep: true
        },
        monthlyAbsences: {
            handler(newValue) {
                this.monthlyAbsences = newValue;
                this.chartAbsenceGeneralData = setAbsenceGeneralData(this.monthlyAbsences);
                this.calculateAbsencesByType(this.month, this.year);
            },
            deep: true
        },
        absencesByType: {
            handler(newValue) {
                this.absencesByType = newValue;
                this.chartAbsenceTypeData = setAbsenceTypeData(this.absencesByType);
                this.calculateMonthlyAbsencesByClassification(this.month, this.year, this.selectedAbsenceType.id);
            },
            deep: true
        },
        monthlyAbsencesByClassification: {
            handler(newValue) {
                this.monthlyAbsencesByClassification = newValue;
                this.chartAbsenceSubtypeData = setAbsenceSubtypeData(this.selectedAbsenceType.type, this.monthlyAbsencesByClassification);
                this.calculateMonthlyAbsencesByResponsible(this.month, this.year);
                this.calculateMonthlyPaymentsByResponsible(this.month, this.year);
            },
            deep: true
        },
        monthlyAbsencesByResponsible: {
            handler(newValue) {
                this.monthlyAbsencesByResponsible = newValue;
                this.chartAbsenceResponsibleData = setAbsenceResponsibleData(this.monthlyAbsencesByResponsible);
            },
            deep: true
        },
    },
    methods: {
        getAbsences() {
            axios.get(`/absences`)
                .then((response) => {
                    this.absences = response.data.absences;
                })
                .catch(error => {
                    console.error('Error al cargar las ausencias:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        getAreasByCampus() {
            axios.get(`/areas-data/${this.campus_id}/campus`)
                .then((response) => {
                    this.areas = response.data.areas;
                })
                .catch(error => {
                    console.error('Error al cargar las áreas:', error);
                });
        },
        changeView(view) {
            if (view === 'absence_indicators') {
                this.absence_indicators = true;
                this.disability_control = false;
                this.eps_payments = false;
            } else if (view === 'disability_control') {
                this.absence_indicators = false;
                this.disability_control = true;
                this.eps_payments = false;

                this.$nextTick(() => {
                    disabilitiesDatatable();
                });
            } else if (view === 'eps_payments') {
                this.absence_indicators = false;
                this.disability_control = false;
                this.eps_payments = true;
            }
        },
        changeCampus() {
            if (this.campus_id === '') {
                this.filteredAbsences = this.absences;
            } else {
                this.filteredAbsences = this.absences.filter(
                    (absence) => absence.campus_id === this.campus_id
                );
                this.getAreasByCampus();
            }
            this.area_id = '';
        },
        changeArea() {
            if (this.area_id != '') {
                this.filteredAbsences = this.absences.filter(
                    (absence) => absence.campus_id === this.campus_id && absence.area_id === this.area_id
                );
            }
        },
        changeSupportFile(e) {
            this.support_file = e.target.files[0]
        },
        cleanFilters() {
            console.log('Limpiando filtros');
            this.campus_id = '';
            this.areas = null;
            this.area_id = '';
            this.filteredAbsences = cloneDeep(this.absences);
        },
        generateYears() {
            const currentYear = new Date().getFullYear();
            return [currentYear - 2, currentYear - 1, currentYear];
        },
        calculateMonthlyAbsences() {
            const monthlyDays = {
                1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0,
                7: 0, 8: 0, 9: 0, 10: 0, 11: 0, 12: 0,
            };

            // this.absences.forEach((absence) => {
            this.filteredAbsences.forEach((absence) => {
                const startDate = new Date(`${absence.start_date}T00:00:00`);
                const endDate = new Date(`${absence.end_date}T00:00:00`);

                if (
                    startDate.getFullYear() <= this.year &&
                    endDate.getFullYear() >= this.year
                ) {
                    this.distributeDaysAcrossMonths(startDate, endDate, parseFloat(absence.days), monthlyDays);
                }
            });

            this.monthlyAbsences = monthlyDays;
        },
        distributeDaysAcrossMonths(startDate, endDate, totalDays, monthlyDays) {
            let currentDate = new Date(startDate);
            const finalDate = new Date(endDate);

            let daysLeft = totalDays;

            while (currentDate <= finalDate && daysLeft > 0) {
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;

                // Procesar solo los meses del año actual
                if (currentYear === this.year) {
                    // Calcular días disponibles en el mes actual desde la fecha de inicio
                    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
                    const startDay = currentDate.getDate();
                    const remainingDaysInMonth =
                    currentDate.getMonth() === startDate.getMonth() && currentDate.getFullYear() === startDate.getFullYear()
                        ? daysInMonth - startDay + 1
                        : daysInMonth;

                    // Si estamos en el último mes, ajustar a los días restantes en el rango
                    const daysToEnd = finalDate.getDate();
                    const daysToAdd =
                    currentDate.getMonth() === endDate.getMonth() && currentDate.getFullYear() === endDate.getFullYear()
                        ? Math.min(daysLeft, daysToEnd - startDay + 1)
                        : Math.min(daysLeft, remainingDaysInMonth);

                    monthlyDays[currentMonth] += daysToAdd;
                    daysLeft -= daysToAdd;
                }

                // Avanzar al primer día del siguiente mes
                currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            }
        },
        calculateAbsencesByType(month, year) {
            const absencesByType = {
                1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0, 7: 0, 8: 0
            };

            this.filteredAbsences.forEach(absence => {
                const startDate = new Date(`${absence.start_date}T00:00:00`);
                const endDate = new Date(`${absence.end_date}T00:00:00`);

                while (startDate <= endDate) {
                    if (
                        startDate.getMonth() + 1 === month && // Coincide el mes
                        startDate.getFullYear() === year      // Coincide el año
                    ) {
                        absencesByType[absence.absence_type_id] += 1;
                    }
                    startDate.setDate(startDate.getDate() + 1);
                }
            });

            this.absencesByType = absencesByType;
        },
        calculateMonthlyAbsencesByClassification(month, year, absenceTypeId) {
            const absencesBySubtype = {};
            const absencesBySegment = {};

            const absencesWithSubtype = this.filteredAbsences.filter(absence => absence.absence_subtype !== null);
            const absenceWithDiseaseClassificationCode = this.filteredAbsences.filter(absence => absence.disease_classification_code !== null);

            if ([6, 7, 8].includes(absenceTypeId)) {
                absencesWithSubtype.forEach(absence => {
                    if (absence.absence_type_id === absenceTypeId) {

                        const startDate = new Date(`${absence.start_date}T00:00:00`);
                        const endDate = new Date(`${absence.end_date}T00:00:00`);
                        const absenceSubtype = absence.absence_subtype;

                        while (startDate <= endDate) {
                            if (
                                startDate.getMonth() + 1 === month &&
                                startDate.getFullYear() === year
                            ) {
                                if (!absencesBySubtype[absenceSubtype]) {
                                    absencesBySubtype[absenceSubtype] = 0;
                                }
                                absencesBySubtype[absenceSubtype] += 1;
                            }
                            startDate.setDate(startDate.getDate() + 1);
                        }
                    }
                });

                this.monthlyAbsencesByClassification = absencesBySubtype;
            } else {
                absenceWithDiseaseClassificationCode.forEach(absence => {
                    if (absence.absence_type_id === absenceTypeId) {

                        const startDate = new Date(`${absence.start_date}T00:00:00`);
                        const endDate = new Date(`${absence.end_date}T00:00:00`);
                        let segment = absence.segment.segment;

                        if (segment && (segment == 'INFECCIOSAS/ DE LA VOZ' || segment == 'DE LA VOZ')) {
                            segment = 'DE LA VOZ';
                        }

                        while (startDate <= endDate) {
                            if (
                                startDate.getMonth() + 1 === month &&
                                startDate.getFullYear() === year
                            ) {
                                if (!absencesBySegment[segment]) {
                                    absencesBySegment[segment] = 0;
                                }
                                absencesBySegment[segment] += 1;
                            }
                            startDate.setDate(startDate.getDate() + 1);
                        }
                    }
                });

                this.monthlyAbsencesByClassification = absencesBySegment;
            }
        },
        isDateInMonth(date, month, year) {
            const checkDate = new Date(date);
            return checkDate.getMonth() + 1 === month &&
                checkDate.getFullYear() === year;
        },
        calculateDailySalary(salary) {
            return salary / 30;
        },
        getAbsenceChain(absence) {
            const chain = [absence];

            if (![1, 2, 3, 4, 5].includes(absence.absence_type_id)) {
                return chain;
            }

            let currentAbsence = absence;
            while (true) {
                const extension = this.absences.find(a =>
                    a.parent_absence_id === currentAbsence.id &&
                    new Date(a.start_date).getTime() ===
                    new Date(currentAbsence.end_date).getTime() + 86400000
                );

                if (!extension) break;
                chain.push(extension);
                currentAbsence = extension;
            }

            return chain;
        },
        calculateMonthlyAbsencesByResponsible(month, year) {
            const absencesByResponsible = {
                company: 0,
                eps: 0,
                arl: 0
            };

            const processedIds = new Set();

            this.filteredAbsences.forEach(absence => {
                if (processedIds.has(absence.id)) return;
                if (absence.parent_absence_id) return;

                const absenceChain = this.getAbsenceChain(absence);
                absenceChain.forEach(a => processedIds.add(a.id));

                // Para el caso 2 (tipos 6, 7, 8), todo va a la empresa
                if ([6, 7, 8].includes(absence.absence_type_id)) {
                    const startDate = new Date(`${absence.start_date}T00:00:00`);
                    const endDate = new Date(`${absence.end_date}T00:00:00`);
                    let currentDate = new Date(startDate);

                    while (currentDate <= endDate) {
                        if (this.isDateInMonth(currentDate, month, year)) {
                            absencesByResponsible.company += 1;
                        }
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    return;
                }

                // Para el caso 1 (tipos 1, 2, 3, 4, 5)
                let totalDaysBeforeMonth = 0;
                let daysInCurrentMonth = [];
                const firstDayOfMonth = new Date(year, month - 1, 1);

                // Recopilamos todos los días de ausencia cronológicamente
                let allAbsenceDays = [];
                absenceChain.forEach(a => {
                    const startDate = new Date(`${a.start_date}T00:00:00`);
                    const endDate = new Date(`${a.end_date}T00:00:00`);
                    let currentDate = new Date(startDate);

                    while (currentDate <= endDate) {
                        if (currentDate < firstDayOfMonth) {
                            totalDaysBeforeMonth++;
                        } else if (this.isDateInMonth(currentDate, month, year)) {
                            daysInCurrentMonth.push(new Date(currentDate));
                        }
                        allAbsenceDays.push(new Date(currentDate));
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                });

                const totalDaysInMonth = daysInCurrentMonth.length;

                if (absence.absence_type_id === 3) {
                    // Si es tipo 3, todo va a la ARL
                    absencesByResponsible.arl += totalDaysInMonth;
                } else if (absence.absence_type_id === 5) {
                    // Si es tipo 5, todo va a la EPS
                    absencesByResponsible.eps += totalDaysInMonth;
                } else if ([1, 2, 4].includes(absence.absence_type_id)) {
                    const totalAbsenceDays = allAbsenceDays.length;

                    // Calculamos cuántos de los primeros 2 días caen en el mes actual
                    const remainingCompanyDays = Math.max(0, 2 - totalDaysBeforeMonth);
                    const daysForCompany = Math.min(remainingCompanyDays, totalDaysInMonth);
                    const daysForEPS = totalDaysInMonth - daysForCompany;

                    // Asignamos los días
                    absencesByResponsible.company += daysForCompany;
                    absencesByResponsible.eps += daysForEPS;
                }
            });

            // return absencesByResponsible;

            this.monthlyAbsencesByResponsible = absencesByResponsible;
        },
        calculateMonthlyPaymentsByResponsible(month, year) {
            const paymentsByResponsible = {
                company: 0,
                eps: 0,
                arl: 0
            };

            const processedIds = new Set();

            this.filteredAbsences.forEach(absence => {
                if (processedIds.has(absence.id)) return;
                if (absence.parent_absence_id) return;

                const absenceChain = this.getAbsenceChain(absence);
                absenceChain.forEach(a => processedIds.add(a.id));

                const dailySalary = this.calculateDailySalary(absence.collaborator_contract.salary);

                // Para el caso 2 (tipos 6, 7, 8), todo va a la empresa
                if ([6, 7, 8].includes(absence.absence_type_id)) {
                    const startDate = new Date(`${absence.start_date}T00:00:00`);
                    const endDate = new Date(`${absence.end_date}T00:00:00`);
                    let currentDate = new Date(startDate);

                    while (currentDate <= endDate) {
                        if (this.isDateInMonth(currentDate, month, year)) {
                            paymentsByResponsible.company += dailySalary;
                        }
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                    return;
                }

                // Para el caso 1 (tipos 1, 2, 3, 4, 5)
                let totalDaysBeforeMonth = 0;
                let daysInCurrentMonth = [];
                const firstDayOfMonth = new Date(year, month - 1, 1);

                // Recopilamos todos los días de ausencia cronológicamente
                let allAbsenceDays = [];
                absenceChain.forEach(a => {
                    const startDate = new Date(`${a.start_date}T00:00:00`);
                    const endDate = new Date(`${a.end_date}T00:00:00`);
                    let currentDate = new Date(startDate);

                    while (currentDate <= endDate) {
                        if (currentDate < firstDayOfMonth) {
                            totalDaysBeforeMonth++;
                        } else if (this.isDateInMonth(currentDate, month, year)) {
                            daysInCurrentMonth.push(new Date(currentDate));
                        }
                        allAbsenceDays.push(new Date(currentDate));
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                });

                const totalDaysInMonth = daysInCurrentMonth.length;
                const totalPaymentForMonth = dailySalary * totalDaysInMonth;

                if (absence.absence_type_id === 3) {
                    // Si es tipo 3, todo va a la ARL
                    paymentsByResponsible.arl += totalPaymentForMonth;
                } else if (absence.absence_type_id === 5) {
                    // Si es tipo 5, todo va a la EPS
                    paymentsByResponsible.eps += totalPaymentForMonth;
                } else if ([1, 2, 4].includes(absence.absence_type_id)) {
                    const totalAbsenceDays = allAbsenceDays.length;

                    if (totalAbsenceDays <= 2) {
                        // Si la ausencia total es de 2 días o menos, todo el pago va a la empresa
                        paymentsByResponsible.company += totalPaymentForMonth;
                    } else {
                        // Calculamos cuántos de los primeros 2 días caen en el mes actual
                        const remainingCompanyDays = Math.max(0, 2 - totalDaysBeforeMonth);
                        const daysForCompany = Math.min(remainingCompanyDays, totalDaysInMonth);

                        if (daysForCompany > 0) {
                            const companyPayment = dailySalary * daysForCompany;
                            paymentsByResponsible.company += companyPayment;

                            // Para los días restantes aplicamos la distribución porcentual
                            const remainingPayment = dailySalary * (totalDaysInMonth - daysForCompany);
                            paymentsByResponsible.eps += remainingPayment * 0.666667;
                            paymentsByResponsible.company += remainingPayment * 0.333333;
                        } else {
                            // Si todos los días del mes son para EPS, aplicamos la distribución porcentual al total
                            paymentsByResponsible.eps += totalPaymentForMonth * 0.666667;
                            paymentsByResponsible.company += totalPaymentForMonth * 0.333333;
                        }
                    }
                }
            });

            // Redondear los valores de pago
            for (let key in paymentsByResponsible) {
                paymentsByResponsible[key] = Math.round(paymentsByResponsible[key]);
            }

            this.monthlyPaymentsByResponsible = paymentsByResponsible;
        },
        processAbsenceChains(absences, eps, absence_types) {
            // Función auxiliar para obtener la cadena completa de una ausencia
            function getAbsenceChain(absence) {
                const chain = [absence];

                // Solo continuar si el tipo de ausencia está entre 1-5
                if (![1, 2, 3, 4, 5].includes(absence.absence_type_id)) {
                    return chain;
                }

                let currentAbsence = absence;
                while (true) {
                    const extension = absences.find(a =>
                        a.parent_absence_id === currentAbsence.id &&
                        new Date(a.start_date).getTime() ===
                        new Date(currentAbsence.end_date).getTime() + 86400000
                    );

                    if (!extension) break;
                    chain.push(extension);
                    currentAbsence = extension;
                }

                return chain;
            }

            const processedIds = new Set();
            const result = [];

            absences.forEach(absence => {
                // Omitir si ya fue procesada o si es una prórroga
                if (processedIds.has(absence.id) || absence.parent_absence_id) {
                    return;
                }

                const absenceChain = getAbsenceChain(absence);

                // console.log(absenceChain);

                // Marcar todas las ausencias en la cadena como procesadas
                absenceChain.forEach(a => processedIds.add(a.id));

                // Obtener la última ausencia en la cadena para el diagnóstico final
                const lastAbsence = absenceChain[absenceChain.length - 1];

                // Buscar el nombre de la EPS
                const epsName = eps.find(e => e.id === absence.collaborator_contract.eps_id)?.name || 'N/A';

                // Buscar el tipo de ausencia
                const absenceType = absence_types.find(t => t.id === lastAbsence.absence_type_id)?.type || 'N/A';

                // Calcular días totales usando fechas de inicio y fin
                const startDate = new Date(absence.start_date);
                const endDate = new Date(lastAbsence.end_date);
                const totalDays = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;

                // Crear el registro consolidado
                const consolidatedRecord = {
                    collaborator_id: absence.collaborator_id,
                    document_number: absence.collaborator.document_number,
                    name: absence.collaborator.name,
                    first_surname: absence.collaborator.first_surname,
                    second_surname: absence.collaborator.second_surname,
                    absence_type_id: lastAbsence.absence_type_id,
                    absence_type: absenceType,
                    start_date: absence.start_date,
                    end_date: lastAbsence.end_date,
                    eps_id: absence.collaborator_contract.eps_id,
                    eps_name: epsName,
                    total_days: totalDays,
                    chain_length: absenceChain.length,
                    absences_in_chain: absenceChain.map(a => ({
                        id: a.id,
                        absence_type_id: a.absence_type_id,
                        disease_classification_code: a.disease_classification_code,
                        description: a.description,
                        start_date: a.start_date,
                        end_date: a.end_date,
                        days: Math.round(a.days),
                        absence_status: a.absence_status,
                    }))
                };

                result.push(consolidatedRecord);
            });

            this.consolidatedAbsences = result;
        },
        showResponsiblePaymentDetail(chartAbsenceResponsibleData) {
            const modal = document.querySelector('.responsible-payment-detail-modal');
            document.body.appendChild(modal);
            modal.style.zIndex = '1050';
        },
        showAbsenceChain(absenceChain) {
            const modal = document.querySelector('.absence-chain-detail-modal');
            document.body.appendChild(modal);
            modal.style.zIndex = '1050';

            this.selected_absence_chain = absenceChain;
        },
        showAbsenceChainDetail(absenceChain) {
            // Primero, destruye la tabla si ya existe
            let table = $('#dt_disability_detail');
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }

            // Luego actualiza los datos
            this.selected_absence_chain = absenceChain;
            this.show_absence_chain_detail = true;

            // Espera a que Vue actualice el DOM
            this.$nextTick(() => {
                // Inicializa DataTable en la tabla actualizada
                disabilityDetailDatatable();
            });
        },
        showPayments(absence) {
            this.selected_absence = absence;

            this.$nextTick(() => {
                const modal = document.querySelector('.absence-payments-modal');

                if (!modal) return;

                // Mueve el modal al final del body (clave)
                document.body.appendChild(modal);

                // Muestra el modal con Bootstrap
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
                modalInstance.show();
            });
        },
        showDisabilityDetail(absence) {
            // console.log('Ausencia seleccionada:', absence);
            this.selectedAbsence = absence;
            // console.log(this.selected_absence);

            this.$nextTick(() => {
                const modal = document.querySelector('.absence-detail-modal');

                if (!modal) return;

                // Mueve el modal al final del body (clave)
                document.body.appendChild(modal);

                // Muestra el modal con Bootstrap
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
                modalInstance.show();
            });
        },
        editDisability(absence) {
            this.selectedAbsence = absence;

            if (this.selectedAbsence && this.selectedAbsence.absence_status) {
                this.absence_status_id = this.selectedAbsence.absence_status.id ?? '';
                this.absence_status_type_id = this.selectedAbsence.absence_status.absence_status_type_id ?? '';
                this.authorized_value = this.selectedAbsence.absence_status.authorized_value ?? '';
                this.paid_value = this.selectedAbsence.absence_status.paid_value ?? '';
                this.paid_days = this.selectedAbsence.absence_status.paid_days ?? '';
                this.payment_date = this.selectedAbsence.absence_status.payment_date ?? '';
                this.observations = this.selectedAbsence.absence_status.observations ?? '';
                this.support_file = null
            } else {
                this.absence_status_id = '';
                this.absence_status_type_id = '';
                this.authorized_value = '';
                this.paid_value = '';
                this.paid_days = '';
                this.payment_date = '';
                this.observations = '';
                this.support_file = null
            }

            this.$nextTick(() => {
                const modal = document.querySelector('.absence-chain-edit-modal');

                if (!modal) return;

                // Mueve el modal al final del body (clave)
                document.body.appendChild(modal);

                // Muestra el modal con Bootstrap
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
                modalInstance.show();
            });
        },
        updateAbsenceStatus() {
            const modal = document.querySelector('.absence-chain-edit-modal');

            let fd = new FormData()

            fd.append('absence_id', this.selectedAbsence.id)
            fd.append('absence_status_type_id', this.absence_status_type_id)
            fd.append('authorized_value', this.authorized_value)
            fd.append('paid_value', this.paid_value)
            fd.append('paid_days', this.paid_days)
            fd.append('payment_date', this.payment_date)
            fd.append('observations', this.observations)
            fd.append('support_file', this.support_file)
            fd.append('_method', 'PUT')

            axios.post(`/absence-status/${this.absence_status_id}/update`, fd)
                .then((response) => {
                    this.getAbsences();
                    this.show_absence_chain_detail = false;

                    modal.style.display = 'none';
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style = '';

                    $('.absence-chain-edit-modal').modal('hide');
                    this.$refs.support_file.value = '';
                })
                .catch(error => {
                    console.error('Error al actualizar la ausencia:', error);
                    this.errors = error.response.data.errors;
                });
        },
        downloadSupportFile(absence_id) {
            axios.get(`/absence-status/${absence_id}/download`)
            .then(response => {
                window.open(response.data.support_download_url, '_blank');
            })
            .catch(e => {
                console.error('Error:', e);
            })
        },
        numberFormat(number) {
            try {
                const roundedNumber = Math.round(number);
                return roundedNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            } catch (error) {
                console.error('Error al formatear número:', error);
                return '0';
            }
        }
    },
};
</script>

<style scoped>
    @import './../../assets/css/custom.css';

    .data-grid {
        display: grid;
        /* grid-template-columns: 1fr 2fr; */
        grid-template-columns: 30% 70%;
        /* grid-template-rows: repeat(12, auto); */
        gap: 10px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 20px;
        align-items: center;
    }

    .label {
        font-weight: bold;
        text-align: left;
        padding-right: 10px;
    }

    .value {
        text-align: left;
        color: #333;
        background-color: #f9f9f9;
        border: 1px dotted #ccc;
        padding: 5px;
        border-radius: 4px;
    }

    .btn-mh-dark-blue.active {
        background-color: #0dacff;
        color: #fff;
    }
</style>
