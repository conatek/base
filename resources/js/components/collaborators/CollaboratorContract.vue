<template>
    <div>
        <div v-if="message !== ''" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
            <span class="pe-2">
                <i class="fa fa-star"></i>
            </span>
            {{ message }}
        </div>

        <button @click="addContract" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar contrato</button>

        <!-- <div class="main-card mb-3 card"> -->
        <div v-if="contracts && contracts.length > 0" class="main-card mb-3 card-hover-shadow">
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
                    :style-class="'vgt-table bordered condensed'"
                >
                    <template #table-row="props">
                        <span v-if="props.column.field === 'status'" class="badge rounded-pill" style="width: 100px;" :class="props.row.status === 'Vigente' ? 'bg-success' : 'bg-danger'">
                            {{ props.row.status }}
                        </span>
                        <span v-else-if="props.column.field === 'actions'">
                            <template v-if="props.row.status === 'Vigente'">
                                <button class="btn btn-sm btn-success mx-1" @click="duplicateContract(props.row.id)">
                                    <font-awesome-icon :icon="['fas', 'plus']" /> Prórroga
                                </button>

                                <button
                                    class="btn btn-sm btn-warning mx-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#contractDetailModal"
                                    @click="showContract(props.row.id)"
                                >
                                    <font-awesome-icon :icon="['fas', 'eye']" /> Mostrar
                                </button>

                                <button class="btn btn-sm btn-primary mx-1" @click="editContract(props.row.id)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" /> Editar
                                </button>
                                <button class="btn btn-sm btn-danger mx-1" @click="showDeleteAlert(props.row)">
                                    <font-awesome-icon :icon="['fas', 'trash-can']" /> Eliminar
                                </button>
                            </template>
                            <template v-else>
                                <button
                                    class="btn btn-sm btn-warning mx-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#contractDetailModal"
                                    @click="showContract(props.row.id)"
                                >
                                    <font-awesome-icon :icon="['fas', 'eye']" /> Mostrar
                                </button>
                            </template>
                        </span>
                        <span v-else>
                            {{ props.formattedRow[props.column.field] }}
                        </span>
                    </template>
                </vue-good-table>
            </div>
        </div>

        <div v-else class="empty-state mb-3">
            <div class="empty-state__art" aria-hidden="true">
                <svg width="140" height="100" viewBox="0 0 300 200" role="img">
                    <defs>
                    <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#eef2ff"/>
                        <stop offset="100%" stop-color="#e0f2fe"/>
                    </linearGradient>
                    </defs>
                    <rect x="20" y="50" width="260" height="110" rx="10" fill="url(#grad)" />
                    <rect x="40" y="70" width="220" height="18" rx="4" fill="#cbd5e1"/>
                    <rect x="40" y="96" width="160" height="18" rx="4" fill="#e2e8f0"/>
                    <rect x="40" y="122" width="190" height="18" rx="4" fill="#e2e8f0"/>
                </svg>
            </div>
            <h2 class="empty-state__title">No hay contratos disponibles para este colaborador</h2>
            <p class="empty-state__desc">Puedes agregar un nuevo contrato haciendo clic <strong @click="addContract" style="cursor: pointer;color: #127cb3;">aquí</strong>.</p>
        </div>

        <div class="modal fade" id="contractDetailModal" tabindex="-1" aria-hidden="true" ref="contractModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalle de Contrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="selected_contract" class="data-grid">
                            <div class="label">Colaborador:</div>
                            <div class="value">{{ collaborator.name }} {{ collaborator.first_surname }} {{ collaborator.second_surname }}</div>

                            <div class="label">Cargo:</div>
                            <div class="value">{{ selected_contract.position.name }}</div>

                            <div class="label">Salario:</div>
                            <div class="value">{{ numberFormat(selected_contract.salary) }}</div>

                            <div class="label">Tipo de Contrato:</div>
                            <div class="value">{{ selected_contract.contract_type.name }}</div>

                            <div class="label">Fecha de Ingreso:</div>
                            <div class="value">{{ selected_contract.contract_start_date }}</div>

                            <div class="label">Fecha de Terminación:</div>
                            <div class="value">{{ selected_contract.contract_end_date ? selected_contract.contract_end_date : 'Sin asignar' }}</div>

                            <div class="label">Fecha de Terminación Prueba:</div>
                            <div class="value">{{ selected_contract.test_period_end_date ? selected_contract.test_period_end_date : 'Sin asignar' }}</div>

                            <div class="label">Observaciones:</div>
                            <div class="value">{{ selected_contract.observations }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <!-- <button v-if="selected_absence && selected_absence.support_file_url"
                            @click="downloadSupportFile(selected_absence.id)"
                            type="button" class="btn btn-primary"
                            data-bs-dismiss="modal"
                        ><i class="fa fa-download"></i> Descargar Soporte Incapacidad</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selected_contract == null && add_contract == true && edit_contract == false && show_contract == false" class="row">
            <div class="col-md-12 col-lg-6">
                <form @submit.prevent="storeContract" enctype="multipart/form-data">
                    <div class="card-hover-shadow card-border mb-3 card">
                        <div class="card-header">
                            Información Contractual
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="position_id" class="form-label">Cargo*</label>
                                        <select v-model="position_id" name="position_id" class="form-control"  id="position_id">
                                            <option value="" disabled selected hidden>Seleccionar Cargo</option>
                                            <option v-for="position_type in position_types" :value="position_type.id">{{ position_type.name }}</option>
                                        </select>
                                        <span v-if="errors && errors.position_id" class="error text-danger" for="position_id">{{ errors.position_id[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="salary" class="form-label">Salario*</label>
                                        <input v-model="salary" name="salary" id="salary" type="text" class="form-control" placeholder="Ingrese el salario">
                                        <span v-if="errors && errors.salary" class="error text-danger" for="salary">{{ errors.salary[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="contract_type_id" class="form-label">Tipo de contrato*</label>
                                        <select v-model="contract_type_id" name="contract_type_id" class="form-control"  id="contract_type_id">
                                            <option value="" disabled selected hidden>Seleccionar Tipo Contrato</option>
                                            <option v-for="contract_type in contract_types" :value="contract_type.id">{{ contract_type.name }}</option>
                                        </select>
                                        <span v-if="errors && errors.contract_type_id" class="error text-danger" for="contract_type_id">{{ errors.contract_type_id[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="contract_start_date" class="form-label">Fecha de ingreso*</label>
                                        <input v-model="contract_start_date" name="contract_start_date" id="contract_start_date" type="date" class="form-control">
                                        <span v-if="errors && errors.contract_start_date" class="error text-danger" for="contract_start_date">{{ errors.contract_start_date[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="contract_end_date" class="form-label">Fecha de terminación</label>
                                        <input v-model="contract_end_date" name="contract_end_date" id="contract_end_date" type="date" class="form-control">
                                        <span v-if="errors && errors.contract_end_date" class="error text-danger" for="contract_end_date">{{ errors.contract_end_date[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="position-relative mb-3">
                                        <label for="test_period_end_date" class="form-label">Fecha de terminación prueba</label>
                                        <input v-model="test_period_end_date" name="test_period_end_date" id="test_period_end_date" type="date" class="form-control">
                                        <span v-if="errors && errors.test_period_end_date" class="error text-danger" for="test_period_end_date">{{ errors.test_period_end_date[0] }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="position-relative mb-3">
                                        <label for="observations" class="form-label">Observaciones</label>
                                        <textarea v-model="observations" name="observations" id="observations" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                        <span v-if="errors && errors.observations" class="error text-danger" for="observations">{{ errors.observations[0] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <!-- Los campos marcados con * son obligatorios. -->
                            <button type="submit" class="mt-2 btn btn-primary">Guardar</button>

                            <button @click="reset" type="button" class="mt-2 btn btn-secondary mx-2">Cancelar</button>

                            <!-- <span class="float-end text-muted" style="font-size: 0.95em;">Los campos marcados con * son obligatorios.</span> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div v-if="selected_contract && add_contract == false && edit_contract == true && show_contract == false" class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="updateContract" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Contractual
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="position_id" class="form-label">Cargo*</label>
                                                <select v-model="position_id" name="position_id" class="form-control"  id="position_id">
                                                    <option value="" disabled selected hidden>Seleccionar Cargo</option>
                                                    <option v-for="position_type in position_types" :value="position_type.id">{{ position_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.position_id" class="error text-danger" for="position_id">{{ errors.position_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="salary" class="form-label">Salario*</label>
                                                <input v-model="selected_contract.salary" name="salary" id="salary" type="text" class="form-control" placeholder="Ingrese el salario">
                                                <span v-if="errors && errors.salary" class="error text-danger" for="salary">{{ errors.salary[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="contract_type_id" class="form-label">Tipo de contrato*</label>
                                                <select v-model="contract_type_id" name="contract_type_id" class="form-control"  id="contract_type_id">
                                                    <option value="" disabled selected hidden>Seleccionar Tipo Contrato</option>
                                                    <option v-for="contract_type in contract_types" :value="contract_type.id">{{ contract_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.contract_type_id" class="error text-danger" for="contract_type_id">{{ errors.contract_type_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="contract_start_date" class="form-label">Fecha de ingreso*</label>
                                                <input v-model="contract_start_date" name="contract_start_date" id="contract_start_date" type="date" class="form-control">
                                                <span v-if="errors && errors.contract_start_date" class="error text-danger" for="contract_start_date">{{ errors.contract_start_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="contract_end_date" class="form-label">Fecha de terminación</label>
                                                <input v-model="contract_end_date" name="contract_end_date" id="contract_end_date" type="date" class="form-control">
                                                <span v-if="errors && errors.contract_end_date" class="error text-danger" for="contract_end_date">{{ errors.contract_end_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="test_period_end_date" class="form-label">Fecha de terminación prueba</label>
                                                <input v-model="test_period_end_date" name="test_period_end_date" id="test_period_end_date" type="date" class="form-control">
                                                <span v-if="errors && errors.test_period_end_date" class="error text-danger" for="test_period_end_date">{{ errors.test_period_end_date[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="corporate_email" class="form-label">Correo corporativo</label>
                                                <input v-model="corporate_email" name="corporate_email" id="corporate_email" type="text" class="form-control" placeholder="Ingrese correo corporativo">
                                                <span v-if="errors && errors.corporate_email" class="error text-danger" for="corporate_email">{{ errors.corporate_email[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="corporate_cellphone" class="form-label">Celular corporativo</label>
                                                <input v-model="corporate_cellphone" name="corporate_cellphone" id="corporate_cellphone" type="text" class="form-control" placeholder="Ingrese celular corporativo">
                                                <span v-if="errors && errors.corporate_cellphone" class="error text-danger" for="corporate_cellphone">{{ errors.corporate_cellphone[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Entidades Relacionadas
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_id" class="form-label">Banco*</label>
                                                <select v-model="bank_id" name="bank_id" class="form-control"  id="bank_id">
                                                    <option value="" disabled selected hidden>Seleccionar Banco</option>
                                                    <option v-for="bank_type in bank_types" :value="bank_type.id">{{ bank_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.bank_id" class="error text-danger" for="bank_id">{{ errors.bank_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_account" class="form-label">Número de cuenta*</label>
                                                <input v-model="bank_account" name="bank_account" id="bank_account" type="text" class="form-control" placeholder="Ingrese número de cuenta">
                                                <span v-if="errors && errors.bank_account" class="error text-danger" for="bank_account">{{ errors.bank_account[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="eps_id" class="form-label">EPS*</label>
                                                <select v-model="eps_id" name="eps_id" class="form-control"  id="eps_id">
                                                    <option value="" disabled selected hidden>Seleccionar EPS</option>
                                                    <option v-for="eps_type in eps_types" :value="eps_type.id">{{ eps_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.eps_id" class="error text-danger" for="eps_id">{{ errors.eps_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="arl_id" class="form-label">ARL*</label>
                                                <select v-model="arl_id" name="arl_id" class="form-control"  id="arl_id">
                                                    <option value="" disabled selected hidden>Seleccionar ARL</option>
                                                    <option v-for="arl_type in arl_types" :value="arl_type.id">{{ arl_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.arl_id" class="error text-danger" for="arl_id">{{ errors.arl_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_pension_id" class="form-label">AFP Pensiones*</label>
                                                <select v-model="afp_pension_id" name="afp_pension_id" class="form-control"  id="afp_pension_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.afp_pension_id" class="error text-danger" for="afp_pension_id">{{ errors.afp_pension_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_saving_id" class="form-label">AFP Cesantías*</label>
                                                <select v-model="afp_saving_id" name="afp_saving_id" class="form-control"  id="afp_saving_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.afp_saving_id" class="error text-danger" for="afp_saving_id">{{ errors.afp_saving_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="ccf_id" class="form-label">Caja de compensación familiar*</label>
                                                <select v-model="ccf_id" name="ccf_id" class="form-control"  id="ccf_id">
                                                    <option value="" disabled selected hidden>Seleccionar caja de compensación</option>
                                                    <option v-for="ccf_type in ccf_types" :value="ccf_type.id">{{ ccf_type.name }}</option>
                                                </select>
                                                <span v-if="errors && errors.ccf_id" class="error text-danger" for="ccf_id">{{ errors.ccf_id[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Actualizar</button>

                    <button @click="reset" type="button" class="mt-2 btn btn-secondary mx-2">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { VueGoodTable } from 'vue-good-table-next';

export default {
    name: 'CollaboratorContract',
    components: {
        VueGoodTable,
    },
    props: {
        collaborator: {
            default: null,
        },
    },
    data() {
        return {
            contracts: [],

            position_types: [],
            contract_types: [],

            position_id: '',
            salary: '',
            contract_type_id: '',
            contract_start_date: '',
            contract_end_date: '',
            test_period_end_date: '',
            observations: '',

            selected_contract: null,
            add_contract: false,
            edit_contract: false,
            show_contract: false,

            columns: [],
            rows: [],

            message: '',

            errors: null,
        };
    },
    mounted() {
        this.getContracts(this.collaborator.id);
        this.getContractualInformation();

        const modalEl = this.$refs.contractModal;
        if (!modalEl) return;

        modalEl.addEventListener('hide.bs.modal', this.handleModalHide);
    },
    watch: {
        contracts: {
            handler() {

                if(this.contracts.length > 0) {
                    this.columns = [
                        { label: 'Tipo', field: 'contract_type.name', sortable: false, thClass: 'text-center' },
                        { label: 'Inicio', field: 'contract_start_date', sortable: false, thClass: 'text-center' },
                        {
                            label: 'Terminación',
                            field: 'contract_end_date',
                            sortable: false,
                            formatFn: (value) => value ? value : 'Sin asignar',
                            thClass: 'text-center'
                        },
                        { label: 'Estado', field: 'status', sortable: false, thClass: 'text-center', tdClass: 'text-center' },
                        { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'align-right', thClass: 'align-right' },
                    ];
                    this.rows = this.contracts;
                }
            },
        },
        selected_contract: {
            handler() {
                if(this.selected_contract) {
                    this.position_id = this.selected_contract.position_id;
                    this.salary = this.selected_contract.salary;
                    this.contract_type_id = this.selected_contract.contract_type_id;
                    this.contract_start_date = this.selected_contract.contract_start_date;
                    this.contract_end_date = this.selected_contract.contract_end_date;
                    this.test_period_end_date = this.selected_contract.test_period_end_date;
                } else {
                    this.position_id = '';
                    this.salary = '';
                    this.contract_type_id = '';
                    this.contract_start_date = '';
                    this.contract_end_date = '';
                    this.test_period_end_date = '';
                }
            },
            immediate: true,
            deep: true,
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
                this.deleteContract(item.id);
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
        },
        getContracts(collaborator_id) {
            axios.get(`/contracts/${collaborator_id}`)
            .then(response => {
                this.contracts = response.data.contracts;
            })
            .catch(e => {
                //
            })
        },
        getContractualInformation() {
            axios.get(`/contractual-information`)
            .then(response => {
                this.position_types = response.data.position_types;
                this.contract_types = response.data.contract_types;
            })
            .catch(e => {
                //
            })
        },
        getMessage(msg) {
            if(msg != '' && msg != null) {
                this.message = msg
            }

            setTimeout(() => {
                this.message = ''

                // this.successfully_created_message = false
                // this.successfully_updated_message = false
                // this.successfully_deleted_message = false
            }, 3000)
        },
        addContract(){
            this.selected_contract = null
            this.add_contract = true
            this.edit_contract = false
            this.show_contract = false
        },
        editContract(contract_id){
            this.selected_contract = this.contracts.find(c => c.id === contract_id)
            this.add_contract = false
            this.edit_contract = true
            this.show_contract = false
        },
        showContract(contract_id){
            this.selected_contract = this.contracts.find(c => c.id === contract_id)
            this.add_contract = false
            this.edit_contract = false
            this.show_contract = true

            const modal = document.querySelector('#contractDetailModal');
            document.body.appendChild(modal);
            modal.style.zIndex = '1050';
            // modal.removeAttribute('aria-hidden');
        },
        storeContract() {
            let dataSend = {
                'collaborator_id': this.collaborator.id,
                'position_id': this.position_id,
                'salary': this.salary,
                'contract_type_id': this.contract_type_id,
                'contract_start_date': this.contract_start_date,
                'contract_end_date': this.contract_end_date,
                'test_period_end_date': this.test_period_end_date,
                'observations': this.observations,
            }

            console.log(dataSend);

            axios.post(`/contracts/${this.collaborator.id}`, dataSend).then(
                (res) => {
                    this.getContracts(this.collaborator.id);

                    this.getMessage(res.data.message);

                    this.reset();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        updateContract() {
            let dataSend = {
                'collaborator_id': this.collaborator.id,
                'position_id': this.position_id,
                'salary': this.salary,
                'contract_type_id': this.contract_type_id,
                'contract_start_date': this.contract_start_date,
                'contract_end_date': this.contract_end_date,
                'test_period_end_date': this.test_period_end_date,
            }

            axios.put(`/contracts/${this.selected_contract.id}`, dataSend).then(
                (res) => {
                    this.getContracts(this.collaborator.id);

                    this.getMessage(res.data.message);

                    this.reset();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        deleteContract(id){
            axios.delete(`/contracts/${id}`).then(
                (res) => {
                    this.getContracts(this.collaborator.id);

                    this.getMessage(res.data.message);

                    this.reset();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        reset(){
            this.selected_contract = null
            this.add_contract = false
            this.edit_contract = false
            this.show_contract = false
            this.errors = null
        },
        handleModalHide() {
            const modalEl = this.$refs.contractModal;

            if (modalEl && modalEl.contains(document.activeElement)) {
                document.activeElement.blur();
            }
        },
        numberFormat(number) {
            const exp = /(\d)(?=(\d{3})+(?!\d))/g
            const rep = '$1.'
            let arr = number.toString().split('.')
            arr[0] = arr[0].replace(exp,rep)
            return arr[1] ? arr.join('.'): arr[0]
        },
    },
};
</script>

<style scoped>
.empty-state {
    border: 1px dashed #e5e7eb;
    border-radius: 12px;
    padding: 28px;
    text-align: center;
    background: #ffffff;
}
.empty-state__art { margin-bottom: 14px; }
.empty-state__title {
    font-size: 1.15rem;
    margin: 8px 0 4px;
    color: #0f172a;
}
.empty-state__desc {
    color: #475569;
    margin-bottom: 14px;
}
.empty-state__actions .btn {
    min-width: 160px;
}
</style>
