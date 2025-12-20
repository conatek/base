<template>
    <div class="dashboard-container">
        <div class="row mb-5 align-items-stretch">
      
            <div class="col-md-6 d-flex"> 
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs text-center fw-bold">
                            Distribución por Género
                        </h6>

                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <div class="w-100">
                                <apexchart 
                                    v-if="genderSeries.length > 0"
                                    type="donut" 
                                    height="300" 
                                    :options="genderOptions" 
                                    :series="genderSeries"
                                ></apexchart>
                                <p v-else class="text-center text-muted small">Cargando datos...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs fw-bold">
                            Nivel Académico
                        </h6>
                        
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="academicOptions.xaxis.categories.length > 0"
                                class="w-100"
                                type="bar" 
                                height="300" 
                                :options="academicOptions" 
                                :series="academicSeries"
                            ></apexchart>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 align-items-stretch">
            <div class="col-md-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Estado Civil</h6>
                        <apexchart 
                            v-if="civilOptions.xaxis.categories.length > 0"
                            type="bar" 
                            height="250" 
                            :options="civilOptions" 
                            :series="civilSeries"
                        ></apexchart>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Rangos de Edad</h6>
                        <apexchart 
                            v-if="ageOptions.xaxis.categories.length > 0"
                            type="area" 
                            height="250" 
                            :options="ageOptions" 
                            :series="ageSeries"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 align-items-stretch">
            <div class="col-md-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs fw-bold">
                            Antigüedad en la empresa
                        </h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="lengthServiceSeries[0].data.length > 0"
                                class="w-100"
                                type="bar" 
                                height="250" 
                                :options="lengthServiceOptions" 
                                :series="lengthServiceSeries"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Estrato Social</h6>
                        <apexchart 
                            v-if="strataOptions.xaxis.categories.length > 0"
                            type="bar" 
                            height="250" 
                            :options="strataOptions" 
                            :series="strataSeries"
                        ></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts'; // O 'vue-apexcharts' si usas Vue 2
import axios from 'axios'; // Asegúrate de importar axios si no es global

const genderPalette = ['#F472B6', '#38BDF8'];
// const academicPalette = ['#BC4749', '#6A994E', '#386641', '#A7C957', '#F2E8CF', '#3D405B', '#E07A5F', '#81B29A', '#F2CC8F', '#525B76', '#22333B'];
const academicPalette = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316', '#14B8A6', '#84CC16', '#6366F1'];
// const academicPalette = ['#0F172A', '#1E1B4B', '#1E293B', '#1E3A8A', '#1E40AF', '#1D4ED8', '#2563EB', '#312E81', '#3730A3', '#4338CA', '#4F46E5'];
const civilStatusPalette = ['#064E3B', '#065F46', '#047857', '#059669', '#10B981', '#34D399'];
const strataPalette = ['#431407', '#7C2D12', '#9A3412', '#C2410C', '#EA580C', '#F97316'];
const seniorityPalette = ['#ca8a04', '#eab308', '#d97706', '#b45309'];

export default {
    components: {
        apexchart: VueApexCharts,
    },
    props: {
        company_id: { default: null },
    },
    data() {
        return {
            // --- 1. GÉNERO (Donut) ---
            genderSeries: [], // Se llenará con los datos de la API
            genderOptions: {
                labels: [], // Se llenará con las etiquetas de la API
                colors: genderPalette,
                chart: { type: 'donut' },
                plotOptions: {
                    pie: { 
                        donut: { 
                            size: '70%',
                            labels: { show: true, total: { show: true, label: 'Total' } }
                        } 
                    }
                },
                dataLabels: { enabled: false },
                legend: { position: 'bottom' }
            },

            // --- 2. NIVEL ACADÉMICO (Ahora Barras Verticales) ---
            academicSeries: [{ name: 'Colaboradores', data: [] }],
            academicOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: {
                    bar: { 
                        horizontal: false, // VERTICAL
                        borderRadius: 6,   // Radio en las esquinas
                        distributed: true, // Colores diferentes por barra
                        columnWidth: '60%',
                    }
                },
                colors: academicPalette,
                legend: { show: false }, // Ocultamos leyenda para limpiar
                xaxis: { 
                    categories: [],
                    labels: { rotate: -45, style: { fontSize: '10px' } } // Rotar si hay muchas barras
                }
            },

            // --- 3. RANGOS DE EDAD (Área) ---
            ageSeries: [{ name: 'Cantidad', data: [] }],
            ageOptions: {
                chart: { type: 'area', toolbar: { show: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#8B5CF6'], // Violeta
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2, stops: [0, 90, 100] }
                },
                xaxis: { categories: [] }
            },

            // --- 4. ESTADO CIVIL (Aseguramos consistencia) ---
            civilSeries: [{ name: 'Cantidad', data: [] }],
            civilOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: { 
                    bar: { borderRadius: 6, distributed: true } 
                },
                colors: civilStatusPalette,
                legend: { show: false },
                xaxis: { categories: [] }
            },

            // --- 5. ESTRATO SOCIAL (Aseguramos consistencia) ---
            strataSeries: [{ name: 'Cantidad', data: [] }],
            strataOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: { 
                    bar: { borderRadius: 6, distributed: true } 
                },
                colors: strataPalette,
                legend: { show: false },
                xaxis: { categories: [] }
            },

            // --- 6. ANTIGÜEDAD (Ahora Barras Horizontales) ---
            lengthServiceSeries: [{ name: 'Colaboradores', data: [] }],
            lengthServiceOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: {
                    bar: { 
                        horizontal: true, // HORIZONTAL
                        borderRadius: 6, 
                        distributed: true,
                        barHeight: '50%'
                    }
                },
                colors: seniorityPalette,
                legend: { show: false },
                xaxis: { categories: [] }
            }
        };
    },
    mounted() {
        if (this.company_id) {
            this.loadAllData(this.company_id);
        }
    },
    watch: {
        // Por si el company_id cambia sin recargar la página
        company_id(newVal) {
            if(newVal) this.loadAllData(newVal);
        }
    },
    methods: {
        // Función auxiliar para cargar todo junto
        loadAllData(id) {
            this.getGenderData(id);
            this.getAcademicLevelData(id);
            this.getAgeRangesData(id);
            this.getCivilStatusData(id);
            this.getSocialStrataData(id);
            this.getLengthServiceData(id);
        },

        // --- MÉTODOS DE API ---

        getGenderData(company_id) {
            axios.get(`/gender-data/${company_id}`).then(response => {
                const data = response.data.gender_data;
                // Mapeo para Donut: Values directo a series, Labels a options
                this.genderSeries = data.values;
                this.genderOptions = {
                    ...this.genderOptions,
                    labels: data.labels
                };
            }).catch(e => console.error(e));
        },

        getAcademicLevelData(company_id) {
            axios.get(`/academic-level-data/${company_id}`).then(response => {
                const data = response.data.academic_level_data;
                // Mapeo para Barras: Values a series[0].data, Labels a xaxis.categories
                this.academicSeries = [{ name: 'Empleados', data: data.values }];
                this.academicOptions = {
                    ...this.academicOptions,
                    xaxis: { categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getAgeRangesData(company_id) {
            axios.get(`/age-ranges-data/${company_id}`).then(response => {
                const data = response.data.age_ranges_data;
                this.ageSeries = [{ name: 'Empleados', data: data.values }];
                this.ageOptions = {
                    ...this.ageOptions,
                    xaxis: { categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getCivilStatusData(company_id) {
            axios.get(`/civil-status-data/${company_id}`).then(response => {
                const data = response.data.civil_status_data;
                this.civilSeries = [{ name: 'Empleados', data: data.values }];
                this.civilOptions = {
                    ...this.civilOptions,
                    xaxis: { categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getSocialStrataData(company_id) {
            axios.get(`/social-strata-data/${company_id}`).then(response => {
                const data = response.data.social_strata_data;
                this.strataSeries = [{ name: 'Empleados', data: data.values }];
                this.strataOptions = {
                    ...this.strataOptions,
                    xaxis: { categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getLengthServiceData(company_id) {
            axios.get(`/length-service-data/${company_id}`).then(response => {
                const data = response.data.length_service_data;
                
                // Revertimos el mapeo de treemap a formato de barras estándar
                this.lengthServiceSeries = [{ name: 'Empleados', data: data.values }];
                this.lengthServiceOptions = {
                    ...this.lengthServiceOptions,
                    xaxis: { categories: data.labels }
                };
            }).catch(e => console.error(e));
        }
    }
};
</script>

<style scoped>
/* Un poco de CSS para dar aire */
.card {
    transition: transform 0.2s;
    /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important; */
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25) !important;
}
.font-size-xs {
    font-size: 0.85rem;
    letter-spacing: 0.05em;
}
.rounded-lg {
    border-radius: 0.75rem !important;
}
</style>