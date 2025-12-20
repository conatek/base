<template>
    <div>
        <div class="row">
            <div class="col-sm-12 col-xxl-6">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Próximos Cumpleaños
                    </div>
                    <div class="card-body">
                        <vue-good-table
                            :columns="columnsBirthdays"
                            :rows="next_birthdays"
                            :row-style-class="getRowStyleClass"
                            :pagination-options="{
                                enabled: true,
                                mode: 'records',
                                perPage: 5,
                                perPageDropdown: [5, 10],
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                rowsPerPageLabel: 'Filas',
                                ofLabel: 'de',
                                allLabel: 'Todo'
                            }"
                            style-class="vgt-table table-hover table-bordered"
                            no-data-message="No hay cumpleaños próximos"
                        >
                            <template #table-row="props">
                                <span v-if="props.column.field === 'document'">
                                    {{ (props.row.document).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}
                                </span>

                                <span v-else-if="props.column.field === 'date'">
                                    {{ formatBirthDate(props.row) }}
                                </span>

                                <span v-else-if="props.column.field === 'actions'">
                                    </span>

                                <span v-else>
                                    {{ props.formattedRow[props.column.field] }}
                                </span>
                            </template>
                        </vue-good-table>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-xxl-6">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Vencimiento de Contratos
                    </div>
                    <div class="card-body">
                        <vue-good-table
                            :columns="columnsContracts"
                            :rows="expiring_contracts"
                            :row-style-class="getRowStyleClass"
                            :pagination-options="{
                                enabled: true,
                                mode: 'records',
                                perPage: 5,
                                perPageDropdown: [5, 10],
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                rowsPerPageLabel: 'Filas',
                                ofLabel: 'de',
                                allLabel: 'Todo'
                            }"
                            style-class="vgt-table table-hover table-bordered"
                            no-data-message="No hay contratos por vencer"
                        >
                            <template #table-row="props">
                                <span v-if="props.column.field === 'document'">
                                    {{ (props.row.document).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}
                                </span>

                                <span v-else-if="props.column.field === 'date'">
                                    {{ formatContractDate(props.row) }}
                                </span>

                                <span v-else-if="props.column.field === 'actions'">
                                    </span>

                                <span v-else>
                                    {{ props.formattedRow[props.column.field] }}
                                </span>
                            </template>
                        </vue-good-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { VueGoodTable } from 'vue-good-table-next';
import axios from 'axios'; // Asegúrate de importar axios si no es global

export default {
    name: 'Alerts',
    components: {
        VueGoodTable,
    },
    props: {
        company_id: { default: null, },
    },
    data() {
        return {
            next_birthdays: [],
            expiring_contracts: [],
            gender_data: null, // Agregado para que no falle getGenderData si se usa

            // Definición de columnas para Cumpleaños (sin ordenamiento)
            columnsBirthdays: [
                { label: 'Nombre', field: 'name', sortable: false },
                { label: 'Nº Documento', field: 'document', sortable: false },
                { label: 'Fecha', field: 'date', sortable: false },
                { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'text-end', thClass: 'text-end' },
            ],

            // Definición de columnas para Contratos (sin ordenamiento)
            columnsContracts: [
                { label: 'Nombre', field: 'name', sortable: false },
                { label: 'Nº Documento', field: 'document', sortable: false },
                { label: 'Fecha', field: 'date', sortable: false },
                { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'text-end', thClass: 'text-end' },
            ],
        }
    },
    mounted () {
        this.getNextBirthdays(this.company_id);
        this.getExpiringContracts(this.company_id);
    },
    methods: {
        // Función para asignar clases CSS a las filas (reemplaza el :class del tr)
        getRowStyleClass(row) {
            if (row.week === 'current') return 'bk-green';
            if (row.week === 'next') return 'bk-yellow';
            if (row.week === 'previous') return 'bk-red';
            return '';
        },
        getGenderData(company_id) {
            axios.get(`/gender-data/${company_id}`)
            .then(response => {
                this.gender_data = response.data.gender_data;
                // ... lógica existente ...
            })
            .catch(e => {
                console.error('Error:', e);
            })
        },
        getNextBirthdays(company_id) {
            axios.get(`/get-next-birthdays/${company_id}`)
            .then(response => {
                this.next_birthdays = response.data.next_birthdays;
                // Eliminada la llamada a birthdaysDatatable();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        getExpiringContracts(company_id) {
            axios.get(`/get-expiring-contracts/${company_id}`)
            .then(response => {
                this.expiring_contracts = response.data.expiring_contracts;
                // Eliminada la llamada a contractsDatatable();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        },
        convertMonth(month) {
            const months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return months[month - 1] || '';
        },
        formatDate(date){
            const newDate = new Date(date)
            return `${newDate.getDate()}/${newDate.getMonth()+1 < 10 ?`0${newDate.getMonth()+1}`: newDate.getMonth()+1 }/${newDate.getFullYear()}`
        },
        formatBirthDate(item){
            return `${item.day} de ${this.convertMonth(item.month)}`;
        },
        formatContractDate(item){
            return `${item.day} de ${this.convertMonth(item.month)} de ${item.year}`;
        },
    }
}
</script>

<style scoped>
/* Estilos para VueGoodTable para que reconozca las clases de fondo */
::v-deep .bk-green {
    background-color: #d4edda !important;
}

::v-deep .bk-yellow {
    background-color: #fff3cd !important;
}

::v-deep .bk-red {
    background-color: #f8d7da !important;
}
</style>
