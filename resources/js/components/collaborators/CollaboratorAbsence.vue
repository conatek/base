<template>
    <div class="colaborator-absence">
        <div class="row justify-content-center">
            <div v-if="chartAbsenceCollaboratorData && chartAbsenceCollaboratorOptions" class="col-md-4">
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
                                    :data="chartAbsenceCollaboratorData"
                                    :options="chartAbsenceCollaboratorOptions"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="chartAbsenceTypeData && chartAbsenceTypeOptions" class="col-md-4">
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
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div v-if="chartAbsenceSubtypeData && chartAbsenceSubtypeOptions" class="col-md-4">
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
                </div>
            </div>

            <div v-if="chartAbsenceResponsibleData && chartAbsenceResponsibleOptions" class="col-md-4">
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
                </div>
            </div>
        </div>

        <button v-if="add_absence == false" @click="addAbsence" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar ausentismo</button>

        <div v-if="add_absence == true && edit_absence == false" class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="storeCollaborator" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-border mb-3 card">
                                <div class="card-header">
                                    Agregar Ausentismo
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3 d-flex align-items-end">
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary icheck-mh d-inline">
                                                    <input @change="changeIsExtension"
                                                        type="checkbox"
                                                        id="is_extension"
                                                        name="is_extension"
                                                        class="checkbox-mh"
                                                        v-model="is_extension">
                                                    <label for="is_extension">Es prórroga</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="is_extension && parent_absence.length > 0 && parent_absence[0] && parent_absence[0].id" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="parent_absence_id" class="form-label">Ausencia Padre*</label>
                                                <input
                                                    :value="parent_absence[0] ? `${parent_absence[0].disease_classification_code} - ${parent_absence[0].absence_type.type}` : ''"
                                                    name="parent_absence_id"
                                                    id="parent_absence_id"
                                                    type="text" class="form-control"
                                                    placeholder="Ingrese descripción"
                                                    readonly>
                                                <span v-if="errors && errors.parent_absence_id" class="error text-danger" for="parent_absence_id">{{ errors.parent_absence_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="absence_type_id" class="form-label">Contingencia*</label>
                                                <select v-model="absence_type_id" @change="changeAbsenceType" name="absence_type_id" class="form-control"  id="absence_type_id" :disabled="is_extension">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Contingencia</option>
                                                    <option v-for="absence_type in absence_types" :value="absence_type.id">{{ absence_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.absence_type_id" class="error text-danger" for="absence_type_id">{{ errors.absence_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="support_file" class="form-label">Soporte</label>
                                                <div class="input-group">
                                                    <input @change="onChangeSupportFile" type="file" name="support_file" id="support_file" class="form-control">
                                                </div>
                                                <span v-if="errors && errors.support_file" class="error text-danger" for="support_file">{{ errors.support_file[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="is_extension || (absence_type_id != '' && [1,2,3,4,5].includes(Number(absence_type_id)))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="disease_classification_code" class="form-label">Clasificación Internacional (CIE)*</label>
                                                <input v-model="disease_classification_code" @input="updateClassificationCode" name="disease_classification_code" id="disease_classification_code" type="text" class="form-control" placeholder="Ingrese código CIE" :readonly="is_extension">
                                                <span v-if="errors && errors.disease_classification_code" class="error text-danger" for="disease_classification_code">{{ errors.disease_classification_code[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="description" class="form-label">Descripción*</label>
                                                <input v-model="description" name="description" id="description" type="text" class="form-control" placeholder="Ingrese descripción" readonly>
                                                <span v-if="errors && errors.description" class="error text-danger" for="description">{{ errors.description[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="absence_type_id != '' && [6,7,8].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="absence_subtype" class="form-label">Subtipo de contingencia*</label>
                                                <select v-model="absence_subtype" @change="changeAbsenceSubype" name="absence_subtype" class="form-control"  id="absence_subtype">
                                                    <option value="" disabled selected hidden>Seleccionar Subtipo Contingencia</option>
                                                    <option v-for="absence_subtype in absence_subtypes_filtered" :value="absence_subtype.subtype">{{ absence_subtype.subtype }}</option>
                                                </select>
                                                <span v-if="errors && errors.absence_subtype" class="error text-danger" for="absence_subtype">{{ errors.absence_subtype[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="description" class="form-label">Descripción*</label>
                                                <input v-model="description" name="description" id="description" type="text" class="form-control" placeholder="Ingrese descripción">
                                                <span v-if="errors && errors.description" class="error text-danger" for="description">{{ errors.description[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="start_date" class="form-label">Fecha de Inicio*</label>
                                                <input v-model="start_date"
                                                    name="start_date"
                                                    id="start_date"
                                                    type="date"
                                                    class="form-control"
                                                    :max="end_date || null"
                                                    placeholder="Ingrese fecha de inicio"
                                                    :disabled="is_extension">
                                                <span v-if="errors && errors.start_date" class="error text-danger" for="start_date">{{ errors.start_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="end_date" class="form-label">Fecha de Finalización*</label>
                                                <input v-model="end_date"
                                                    name="end_date"
                                                    id="end_date"
                                                    type="date"
                                                    class="form-control"
                                                    :min="start_date || null"
                                                    placeholder="Ingrese fecha de finalización">
                                                <span v-if="errors && errors.end_date" class="error text-danger" for="end_date">{{ errors.end_date[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="is_extension || (absence_type_id != '' && [1,2,3,4,5].includes(Number(absence_type_id)))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="hours" class="form-label">Horas*</label>
                                                <input v-model="hours" @input="changeHours" name="hours" id="hours" type="text" class="form-control" placeholder="Ingrese horas" step="0.01" readonly>
                                                <span v-if="errors && errors.hours" class="error text-danger" for="hours">{{ errors.hours[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="days" class="form-label">Días*</label>
                                                <input v-model="days" @input="changeDays" name="days" id="days" type="text" class="form-control" placeholder="Ingrese días" step="0.01" readonly>
                                                <span v-if="errors && errors.days" class="error text-danger" for="days">{{ errors.days[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="absence_type_id != '' && [6,7,8].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="hours" class="form-label">Horas*</label>
                                                <input v-model="hours" @input="changeHours" name="hours" id="hours" type="text" class="form-control" placeholder="Ingrese horas" step="0.01">
                                                <span v-if="errors && errors.hours" class="error text-danger" for="hours">{{ errors.hours[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="days" class="form-label">Días*</label>
                                                <input v-model="days" @input="changeDays" name="days" id="days" type="text" class="form-control" placeholder="Ingrese días" step="0.01">
                                                <span v-if="errors && errors.days" class="error text-danger" for="days">{{ errors.days[0] }}</span>
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
                    </div>
                    <button @click="storeAbsence" type="submit" class="mt-2 btn btn-mh-dark-blue">Guardar Ausentismo</button>
                    <button @click="add_absence = false, resetForm" type="button" class="mt-2 ms-2 btn btn-secondary">Cancelar</button>
                </form>
            </div>
        </div>

        <div v-if="add_absence == false && edit_absence == true" class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="updateAbsence" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-border mb-3 card">
                                <div class="card-header">
                                    Editar Ausentismo
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6 mb-3 d-flex align-items-end">
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary icheck-mh d-inline">
                                                    <input @change="changeIsExtension"
                                                        type="checkbox"
                                                        id="is_extension"
                                                        name="is_extension"
                                                        class="checkbox-mh"
                                                        v-model="is_extension"
                                                        disabled>
                                                    <label for="is_extension">Es prórroga</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div v-if="is_extension && parent_absence.length > 0 && parent_absence[0] && parent_absence[0].id" class="col-sm-12 col-md-6 col-lg-6"> -->
                                        <div v-if="is_extension && parent_absence.length > 0 && parent_absence[0]" class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="parent_absence_id" class="form-label">Ausencia Padre*</label>
                                                <input
                                                    :value="parent_absence[0] ? `[ID: ${parent_absence[0].parent_absence_id}] ${parent_absence[0].disease_classification_code} - ${parent_absence[0].absence_type.type}` : ''"
                                                    name="parent_absence_id"
                                                    id="parent_absence_id"
                                                    type="text" class="form-control"
                                                    placeholder="Ingrese descripción"
                                                    readonly>
                                                <span v-if="errors && errors.parent_absence_id" class="error text-danger" for="parent_absence_id">{{ errors.parent_absence_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="absence_type_id" class="form-label">Contingencia*</label>
                                                <select v-model="absence_type_id" @change="changeAbsenceType" name="absence_type_id" class="form-control" id="absence_type_id" :disabled="is_extension">
                                                    <option value="" disabled hidden>Seleccionar Tipo Contingencia</option>
                                                    <option v-for="absence_type in absence_types" :value="absence_type.id">{{ absence_type.type }}</option>
                                                </select>
                                                <span v-if="errors && errors.absence_type_id" class="error text-danger" for="absence_type_id">{{ errors.absence_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="support_file" class="form-label">Soporte</label>
                                                <div class="input-group">
                                                    <input @change="onChangeSupportFile" type="file" name="support_file" id="support_file" class="form-control">
                                                </div>
                                                <span v-if="errors && errors.support_file" class="error text-danger" for="support_file">{{ errors.support_file[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="absence_type_id != '' && [1,2,3,4,5].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="disease_classification_code" class="form-label">Clasificación Internacional (CIE)*</label>
                                                <input v-model="disease_classification_code" @input="updateClassificationCode" name="disease_classification_code" id="disease_classification_code" type="text" class="form-control" placeholder="Ingrese código CIE" :readonly="is_extension">
                                                <span v-if="errors && errors.disease_classification_code" class="error text-danger" for="disease_classification_code">{{ errors.disease_classification_code[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="description" class="form-label">Descripción*</label>
                                                <input v-model="description" name="description" id="description" type="text" class="form-control" placeholder="Ingrese descripción" readonly>
                                                <span v-if="errors && errors.description" class="error text-danger" for="description">{{ errors.description[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="absence_type_id != '' && [6,7,8].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="absence_subtype" class="form-label">Subtipo de contingencia*</label>
                                                <select v-model="absence_subtype" @change="changeAbsenceSubype" name="absence_subtype" class="form-control"  id="absence_subtype">
                                                    <option value="" disabled selected hidden>Seleccionar Subtipo Contingencia</option>
                                                    <option v-for="absence_subtype in absence_subtypes_filtered" :value="absence_subtype.subtype">{{ absence_subtype.subtype }}</option>
                                                </select>
                                                <span v-if="errors && errors.absence_subtype" class="error text-danger" for="absence_subtype">{{ errors.absence_subtype[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="description" class="form-label">Descripción*</label>
                                                <input v-model="description" name="description" id="description" type="text" class="form-control" placeholder="Ingrese descripción">
                                                <span v-if="errors && errors.description" class="error text-danger" for="description">{{ errors.description[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="start_date" class="form-label">Fecha de Inicio*</label>
                                                <input v-model="start_date"
                                                    name="start_date"
                                                    id="start_date"
                                                    type="date"
                                                    class="form-control"
                                                    :max="end_date || null"
                                                    placeholder="Ingrese fecha de inicio"
                                                    :disabled="is_extension">
                                                <span v-if="errors && errors.start_date" class="error text-danger" for="start_date">{{ errors.start_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="end_date" class="form-label">Fecha de Finalización*</label>
                                                <input v-model="end_date" name="end_date" id="end_date" type="date" class="form-control" :min="start_date || null" placeholder="Ingrese fecha de finalización">
                                                <span v-if="errors && errors.end_date" class="error text-danger" for="end_date">{{ errors.end_date[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="absence_type_id != '' && [1,2,3,4,5].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="hours" class="form-label">Horas*</label>
                                                <input v-model="hours" @input="changeHours" name="hours" id="hours" type="text" class="form-control" placeholder="Ingrese horas" step="0.01" readonly>
                                                <span v-if="errors && errors.hours" class="error text-danger" for="hours">{{ errors.hours[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="days" class="form-label">Días*</label>
                                                <input v-model="days" @input="changeDays" name="days" id="days" type="text" class="form-control" placeholder="Ingrese días" step="0.01" readonly>
                                                <span v-if="errors && errors.days" class="error text-danger" for="days">{{ errors.days[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else-if="absence_type_id != '' && [6,7,8].includes(Number(absence_type_id))" class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="hours" class="form-label">Horas*</label>
                                                <input v-model="hours" @input="changeHours" name="hours" id="hours" type="text" class="form-control" placeholder="Ingrese horas" step="0.01">
                                                <span v-if="errors && errors.hours" class="error text-danger" for="hours">{{ errors.hours[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="days" class="form-label">Días*</label>
                                                <input v-model="days" @input="changeDays" name="days" id="days" type="text" class="form-control" placeholder="Ingrese días" step="0.01">
                                                <span v-if="errors && errors.days" class="error text-danger" for="days">{{ errors.days[0] }}</span>
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
                                    <div class="row">
                                        <div class="col-12 text-end">
                                            <button type="button" @click="edit_absence = false" class="btn btn-secondary me-2">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- <div v-if="isLoading == false" class="main-card mb-3 card"> -->
        <div class="main-card mb-3 card">
            <div class="card-body table-responsive">
                <table style="width: 100%;" id="dt_absences" class="table table-cntk table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Contingencia</th>
                            <th class="text-center">Clasificación</th>
                            <th class="text-center">Inicio</th>
                            <th class="text-center">Finalización</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(absence, index) in absences" :key="absence.id">
                            <td class="text-center">{{ absence.id }}</td>
                            <td class="text-left">
                                <span class="mb-2 mr-2 badge bg-success" style="width: 80px;">
                                    {{ absence.parent_absence_id != null ? 'Prórroga' : 'Nueva' }}
                                </span>
                                - {{ absence.absence_type.type }}
                            </td>
                            <td class="text-left">{{ [1,2,3,4,5].includes(absence.absence_type_id) ? absence.disease_classification_code : absence.absence_subtype }}</td>
                            <td class="text-center">{{ absence.start_date }}</td>
                            <td class="text-center">{{ absence.end_date }}</td>
                            <td class="text-end">
                                <button @click="showAbsence(absence)"
                                        type="button"
                                        class="me-2 btn-icon btn btn-sm btn-success"
                                        data-bs-toggle="modal" data-bs-target=".absence-detail-modal">
                                    <i class="fa fa-eye"></i> Mostrar
                                </button>
                                <button @click="editAbsence(absence)"
                                        type="button"
                                        class="me-2 btn-icon btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button @click="showDeleteAlert(absence.id)"
                                        type="button"
                                        class="btn-icon btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade absence-detail-modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Contingencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="selected_absence" class="data-grid">
                            <div class="label">Colaborador:</div>
                            <div class="value">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</div>

                            <div class="label">¿Es prórroga?:</div>
                            <div class="value">{{ selected_absence.is_extension == true ? 'Sí' : 'No' }}</div>

                            <div class="label">Ausencia Padre:</div>
                            <div v-if="parent_absence && parent_absence[0]" class="value">[ID: {{ parent_absence[0].id }}] - {{ parent_absence[0].disease_classification_code }} - {{ parent_absence[0].description }}</div>
                            <div v-else class="value">No Aplica</div>

                            <div class="label">Tipo de Contingencia:</div>
                            <div class="value">{{ selected_absence.absence_type.type }}</div>

                            <div class="label">{{ [1,2,3,4,5].includes(selected_absence.absence_type_id) ? 'Clasificación:' : 'Subtipo' }}</div>
                            <div class="value">{{ [1,2,3,4,5].includes(selected_absence.absence_type_id) ? selected_absence.disease_classification_code : selected_absence.absence_subtype }}</div>

                            <div class="label">Descripción:</div>
                            <div class="value">{{ selected_absence.description }}</div>

                            <div class="label">Fecha de Inicio:</div>
                            <div class="value">{{ selected_absence.start_date }}</div>

                            <div class="label">Fecha de Finalización:</div>
                            <div class="value">{{ selected_absence.end_date }}</div>

                            <div class="label">Horas:</div>
                            <div class="value">{{ selected_absence.hours }}</div>

                            <div class="label">Días:</div>
                            <div class="value">{{ selected_absence.days }}</div>

                            <div class="label">Observaciones:</div>
                            <div class="value">{{ selected_absence.observations != null ? selected_absence.observations : 'Sin asignar' }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button v-if="selected_absence && selected_absence.support_file_url"
                            @click="downloadSupportFile(selected_absence.id)"
                            type="button" class="btn btn-primary"
                            data-bs-dismiss="modal"
                        ><i class="fa fa-download"></i> Descargar Soporte Incapacidad</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Doughnut } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale } from 'chart.js'

import axios from 'axios';
import { absencesDatatable } from '../../assets/js/tables.js';
import {
    setAbsenceCollaboratorData,
    absenceCollaboratorOptions,
    setAbsenceTypeData,
    absenceTypeOptions,
    setAbsenceSubtypeData ,
    absenceSubtypeOptions,
    setAbsenceResponsibleData,
    absenceResponsibleOptions } from '../../assets/js/dataAbsenceCollaboratorGraphics.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale)

export default {
    name: 'CollaboratorAbsence',

    components: {
        Bar,
        Doughnut
    },
    props: {
        collaborator: {
            default: null,
        },
        absence_types: {
            default: null,
        },
        absence_subtypes: {
            default: null,
        },
    },
    data() {
        return {
            dataTableInstance: null,

            absence_type_id: '',
            absence_subtype: '',
            absence_subtypes_filtered: [],
            disease_classification_code: '',
            disease_classification: [],
            description: '',

            absences: [],
            selected_absence: null,

            is_extension: false,
            parent_absence: [],
            parent_absence_id: '',
            support_file: '',

            add_absence: false,
            edit_absence: false,

            start_date: '',
            end_date: '',
            hours: 0,
            days: 0,
            observations: '',

            isLoading: true,

            chartAbsenceCollaboratorData: null,
            chartAbsenceCollaboratorOptions: absenceCollaboratorOptions,

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

            errors: null,
        };
    },
    mounted() {
        this.absence_subtypes_filtered = this.absence_subtypes.filter(item => item.absence_type_id === this.absence_type_id);
        this.getAbsencesByCollaborator(this.collaborator.id);
        this.selectedAbsenceType = this.absence_types.find(item => item.id === 1);
    },
    watch: {
        absences: {
            handler(newValue) {
                this.absences = newValue;
                this.isLoading = false;
                // this.dataTableInstance = absencesDatatable();
                this.calculateMonthlyAbsences();
                this.calculateAbsencesByType();

                this.$nextTick(() => {
                    absencesDatatable();
                });
            },
            deep: true
        },
        monthlyAbsences: {
            handler(newValue) {
                this.monthlyAbsences = newValue;
                this.chartAbsenceCollaboratorData = setAbsenceCollaboratorData(this.monthlyAbsences);
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
        absence_type_id(newValue) {
            this.absence_subtypes_filtered = this.absence_subtypes.filter(
                item => item.absence_type_id === Number(newValue)
            );
        },
        start_date(newValue) {
            if (newValue && this.end_date && [1,2,3,4,5].includes(Number(this.absence_type_id))) {
                this.calculateDaysAndHours();
            }
        },
        end_date(newValue) {
            if (newValue && this.start_date && [1,2,3,4,5].includes(Number(this.absence_type_id))) {
                this.calculateDaysAndHours();
            }
        },
        is_extension(newValue) {
            if (newValue) {
                this.changeIsExtension();
            }
        },
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
                this.deleteAbsence(item)
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
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

            this.absences.forEach((absence) => {
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

            this.absences.forEach(absence => {
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

            const absencesWithSubtype = this.absences.filter(absence => absence.absence_subtype !== null);
            const absenceWithDiseaseClassificationCode = this.absences.filter(absence => absence.disease_classification_code !== null);

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
                // console.log(absenceWithDiseaseClassificationCode);
                // absenceWithDiseaseClassificationCode.forEach(absence => {
                //     if (absence.absence_type_id === absenceTypeId) {

                //         console.log(absence);
                //         console.log(absence.segment);

                //         const startDate = new Date(`${absence.start_date}T00:00:00`);
                //         const endDate = new Date(`${absence.end_date}T00:00:00`);
                //         const segment = absence.segment.segment;

                //         if (segment && (segment == 'INFECCIOSAS/ DE LA VOZ' || segment == 'DE LA VOZ')) {
                //             segment = 'DE LA VOZ';
                //         }

                //         while (startDate <= endDate) {
                //             if (
                //                 startDate.getMonth() + 1 === month &&
                //                 startDate.getFullYear() === year
                //             ) {
                //                 if (!absencesBySegment[segment]) {
                //                     absencesBySegment[segment] = 0;
                //                 }
                //                 absencesBySegment[segment] += 1;
                //             }
                //             startDate.setDate(startDate.getDate() + 1);
                //         }
                //     }
                // });

                // this.monthlyAbsencesByClassification = absencesBySegment;

                console.log(absenceWithDiseaseClassificationCode);
                absenceWithDiseaseClassificationCode.forEach(absence => {
                    if (absence.absence_type_id === absenceTypeId) {
                        console.log(absence);

                        // Verificamos si absence.segment existe antes de acceder a sus propiedades
                        const startDate = new Date(`${absence.start_date}T00:00:00`);
                        const endDate = new Date(`${absence.end_date}T00:00:00`);

                        // Usamos let en lugar de const para poder modificar la variable
                        let segmentValue = 'SIN CLASIFICAR'; // Valor por defecto

                        // Verificamos si absence.segment existe y si tiene la propiedad segment
                        if (absence.segment && absence.segment.segment) {
                            console.log(absence.segment);
                            segmentValue = absence.segment.segment;

                            // Si el segmento es uno de estos valores específicos, lo cambiamos a 'DE LA VOZ'
                            if (segmentValue === 'INFECCIOSAS/ DE LA VOZ' || segmentValue === 'DE LA VOZ') {
                                segmentValue = 'DE LA VOZ';
                            }
                        }

                        // Usamos una copia de startDate para iterar para no modificar la original
                        const currentDate = new Date(startDate);

                        while (currentDate <= endDate) {
                            if (
                                currentDate.getMonth() + 1 === month &&
                                currentDate.getFullYear() === year
                            ) {
                                if (!absencesBySegment[segmentValue]) {
                                    absencesBySegment[segmentValue] = 0;
                                }
                                absencesBySegment[segmentValue] += 1;
                            }
                            currentDate.setDate(currentDate.getDate() + 1);
                        }
                    }
                });
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

            this.absences.forEach(absence => {
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

            this.absences.forEach(absence => {
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

            // return paymentsByResponsible;

            this.monthlyPaymentsByResponsible = paymentsByResponsible;
        },
        onChangeSupportFile(e) {
            this.support_file = e.target.files[0]
        },
        changeIsExtension() {
            if (this.is_extension) {
                if (this.edit_absence) {
                    this.parent_absence = [this.absences.find(item => item.parent_absence_id === this.parent_absence_id)];
                } else {
                    // Buscar la última ausencia médica
                    const lastMedicalAbsence = this.absences
                        .filter(item => [1, 2, 3, 4, 5].includes(item.absence_type_id))
                        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))[0];

                    if (lastMedicalAbsence) {
                        // Establecer los valores del último registro
                        this.parent_absence = [lastMedicalAbsence];
                        this.parent_absence_id = lastMedicalAbsence.id;
                        this.absence_type_id = lastMedicalAbsence.absence_type_id;
                        this.disease_classification_code = lastMedicalAbsence.disease_classification_code;
                        this.description = lastMedicalAbsence.description;

                        // Establecer la fecha de inicio como el día siguiente a la fecha de fin
                        const nextDate = new Date(lastMedicalAbsence.end_date);
                        nextDate.setDate(nextDate.getDate() + 1);
                        this.start_date = nextDate.toISOString().split('T')[0];
                    }
                }
            } else {
                // Solo resetear si no estamos en modo edición
                if (!this.edit_absence) {
                    this.resetForm();
                }
            }
        },
        addAbsence() {
            this.resetForm();
            this.add_absence = true;
            this.edit_absence = false;
        },
        editAbsence(absence) {
            this.add_absence = false;
            this.edit_absence = true;

            this.selected_absence = absence;

            // Asignamos todos los valores directamente
            this.absence_type_id = absence.absence_type_id;
            this.absence_subtype = absence.absence_subtype;
            this.disease_classification_code = absence.disease_classification_code;
            this.description = absence.description;
            this.start_date = absence.start_date;
            this.end_date = absence.end_date;
            this.hours = absence.hours;
            this.days = absence.days;
            this.parent_absence_id = absence.parent_absence_id;
            this.observations = absence.observations == null ? '' : absence.observations;
            this.is_extension = absence.is_extension == 1 ? true : false;

            // Si es una prórroga, cargamos la ausencia padre
            if (absence.parent_absence_id) {
                // this.parent_absence = [absence.parent_absence];
                this.parent_absence = [this.absences.find(item => item.parent_absence_id === this.parent_absence_id)];
            }
        },
        storeAbsence() {
            const formData = new FormData();

            // console.log(this.absence_subtype);

            if(this.support_file) {
                fd.append('support_file', this.support_file)
            }
            formData.append('absence_type_id', this.absence_type_id);
            formData.append('absence_subtype', this.absence_subtype);
            formData.append('disease_classification_code', this.disease_classification_code);
            formData.append('description', this.description);
            formData.append('start_date', this.start_date);
            formData.append('end_date', this.end_date);
            formData.append('hours', this.hours);
            formData.append('days', this.days);
            formData.append('is_extension', this.is_extension);
            formData.append('parent_absence_id', this.parent_absence_id);
            formData.append('observations', this.observations);

            axios.post(`/absences/${this.collaborator.id}`, formData)
                .then((response) => {
                    this.absences = response.data.absences;
                    this.add_absence = false;
                    this.resetForm();

                    this.getAbsencesByCollaborator(this.collaborator.id);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        showAbsence(absence) {
            const modal = document.querySelector('.absence-detail-modal');
            document.body.appendChild(modal);
            modal.style.zIndex = '1050';

            this.selected_absence = absence;
            this.parent_absence = [this.absences.find(item => item.id === absence.parent_absence_id)];
        },
        updateAbsence() {
            const formData = new FormData();

            if (this.support_file) {
                formData.append('support_file', this.support_file);
            }

            formData.append('absence_type_id', this.absence_type_id);
            formData.append('absence_subtype', this.absence_subtype == null ? '' : this.absence_subtype);
            formData.append('disease_classification_code', this.disease_classification_code);
            formData.append('description', this.description);
            formData.append('start_date', this.start_date);
            formData.append('end_date', this.end_date);
            formData.append('hours', this.hours);
            formData.append('days', this.days);
            formData.append('is_extension', this.is_extension);
            formData.append('parent_absence_id', this.parent_absence_id == null ? '' : this.parent_absence_id);
            formData.append('observations', this.observations);
            formData.append('_method', 'PUT')

            axios
                .post(`/absences/${this.collaborator.id}/${this.selected_absence.id}`, formData)
                .then((response) => {
                    this.absences = response.data.absences;
                    this.edit_absence = false;
                    this.resetForm();

                    this.getAbsencesByCollaborator(this.collaborator.id);
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        deleteAbsence(id){
            let url = ''
            axios.delete(`/absences/${this.collaborator.id}/${id}/destroy`).then(
                (res) => {
                    this.absences = res.data.absences;
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
        resetForm() {
            this.absence_type_id = '';
            this.absence_subtype = '';
            this.disease_classification_code = '';
            this.disease_classification = [];
            this.description = '';
            this.start_date = '';
            this.end_date = '';
            this.hours = 0;
            this.days = 0;
            this.is_extension = false;
            this.parent_absence = [];
            this.parent_absence_id = '';
            this.support_file = '';
            this.observations = '';
            this.errors = null;
        },
        getAbsencesByCollaborator(collaborator) {
            axios.get(`/absences/${collaborator}`)
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
        changeAbsenceType() {
            this.absence_subtype = '';
            this.disease_classification_code = '';
            this.disease_classification = [];
            this.description = '';
            this.start_date = '';
            this.end_date = '';
            this.hours = 0;
            this.days = 0;
            this.is_extension = false;
            this.parent_absence_id = '';
            this.support_file = '';
            this.observations = '';
            this.errors = null;
        },
        changeAbsenceSubype() {
            this.disease_classification_code = '';
            this.disease_classification = [];
            this.description = '';
            this.start_date = '';
            this.end_date = '';
            this.hours = 0;
            this.days = 0;
            this.is_extension = false;
            this.parent_absence_id = '';
            this.support_file = '';
            this.observations = '';
            this.errors = null;
        },
        changeHours(e) {
            let input = e.target.value;

            // Permitir solo números y un único punto decimal
            input = input.replace(/[^0-9.]/g, ""); // Elimina caracteres no válidos

            // Asegurar que haya un solo punto decimal
            const parts = input.split(".");
            if (parts.length > 2) {
                input = parts[0] + "." + parts.slice(1).join(""); // Combina solo el primer punto
            }

            // Limitar a 2 decimales
            if (parts.length === 2 && parts[1].length > 2) {
                input = `${parts[0]}.${parts[1].slice(0, 2)}`;
            }

            // Evitar ceros a la izquierda (excepto para decimales como "0.x")
            if (input.startsWith("0") && !input.startsWith("0.") && input.length > 1) {
                input = input.replace(/^0+/, "");
            }

            // Si el valor es válido, actualizar el modelo
            const numericValue = parseFloat(input);
            if (!isNaN(numericValue) || input === "") {
                this.hours = input; // Permite vacío temporalmente
                this.days = numericValue ? (numericValue / 7.67).toFixed(2) : "";
            } else {
                // Restablecer a "0" si el valor no es válido
                this.hours = "0";
                this.days = "";
            }
        },
        changeDays(e) {
            let input = e.target.value;

            // Permitir solo números y un único punto decimal
            input = input.replace(/[^0-9.]/g, "");

            // Asegurar que haya un solo punto decimal
            const parts = input.split(".");
            if (parts.length > 2) {
                input = parts[0] + "." + parts.slice(1).join("");
            }

            // Limitar a 2 decimales
            if (parts.length === 2 && parts[1].length > 2) {
                input = `${parts[0]}.${parts[1].slice(0, 2)}`;
            }

            // Evitar ceros a la izquierda (excepto para decimales como "0.x")
            if (input.startsWith("0") && !input.startsWith("0.") && input.length > 1) {
                input = input.replace(/^0+/, "");
            }

            // Si el valor es válido, actualizar el modelo
            const numericValue = parseFloat(input);
            if (!isNaN(numericValue) || input === "") {
                this.days = input;
                this.hours = numericValue ? (numericValue * 7.67).toFixed(2) : "";
            } else {
                this.days = "0";
                this.hours = "0";
            }
        },
        calculateDaysAndHours() {
            if (this.start_date && this.end_date) {
                const start = new Date(this.start_date);
                const end = new Date(this.end_date);

                // Calcular la diferencia en días
                const diffTime = Math.abs(end - start);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 para incluir el día final

                // Asignar días y calcular horas
                this.days = diffDays.toFixed(2);
                this.hours = (diffDays * 7.67).toFixed(2);
            }
        },
        onKeydownClassificationCode(e) {
            this.disease_classification_code = e.target.value
        },
        updateClassificationCode() {
            this.disease_classification_code = this.disease_classification_code.toUpperCase();

            if (this.disease_classification_code.length === 3 || this.disease_classification_code.length === 4) {
                axios.get(`/absences/classification/${this.disease_classification_code}`).then(
                    (response) => {
                        this.disease_classification = response.data.disease_classification;
                        if (this.disease_classification && this.disease_classification.description) {
                            this.description = this.disease_classification.description;
                        } else {
                            this.description = '';
                        }
                    })
            } else {
                this.disease_classification = [];
            }
        },
        downloadSupportFile(absence_id) {
            // console.log(absence_id);
            axios.get(`/absence/${absence_id}/download`)
            .then(response => {
                window.open(response.data.support_download_url, '_blank');
            })
            .catch(e => {
                console.error('Error:', e);
            })
        },
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
</style>
