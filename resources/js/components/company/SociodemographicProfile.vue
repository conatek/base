<template>
    <div class="dashboard-container">
        <!-- Fila 1: Género y Nivel Académico -->
        <div class="row mb-4 align-items-stretch">
            <div class="col-12 col-lg-6 d-flex mb-4 mb-lg-0"> 
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs text-center fw-bold">
                            Distribución por Género
                        </h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <div class="w-100">
                                <apexchart 
                                    v-if="genderSeries.length > 0"
                                    type="donut" 
                                    :height="chartHeight"
                                    :options="genderOptions" 
                                    :series="genderSeries"
                                ></apexchart>
                                <empty-state v-else icon="gender" message="Aún no hay datos de género registrados" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs fw-bold">
                            Nivel Académico
                        </h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="academicOptions.xaxis.categories.length > 0"
                                class="w-100"
                                type="bar" 
                                :height="chartHeight"
                                :options="academicOptions" 
                                :series="academicSeries"
                            ></apexchart>
                            <empty-state v-else icon="academic" message="Sin información académica disponible" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila 2: Estado Civil y Rangos de Edad -->
        <div class="row mb-4 align-items-stretch">
            <div class="col-12 col-lg-6 d-flex mb-4 mb-lg-0">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Estado Civil</h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="civilOptions.xaxis.categories.length > 0"
                                class="w-100"
                                type="bar" 
                                :height="chartHeightSmall"
                                :options="civilOptions" 
                                :series="civilSeries"
                            ></apexchart>
                            <empty-state v-else icon="civil" message="Estado civil pendiente de registro" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Rangos de Edad</h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="ageOptions.xaxis.categories.length > 0"
                                class="w-100"
                                type="area" 
                                :height="chartHeightSmall"
                                :options="ageOptions" 
                                :series="ageSeries"
                            ></apexchart>
                            <empty-state v-else icon="age" message="Datos de edad no disponibles" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila 3: Antigüedad y Estrato Social -->
        <div class="row mb-4 align-items-stretch">
            <div class="col-12 col-lg-6 d-flex mb-4 mb-lg-0">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-4 font-size-xs fw-bold">
                            Antigüedad en la empresa
                        </h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="lengthServiceSeries[0].data.length > 0"
                                class="w-100"
                                type="bar" 
                                :height="chartHeightSmall"
                                :options="lengthServiceOptions" 
                                :series="lengthServiceSeries"
                            />
                            <empty-state v-else icon="seniority" message="Sin datos de antigüedad" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex">
                <div class="card shadow-sm border-0 rounded-lg w-100">
                    <div class="card-body d-flex flex-column p-3 p-md-4">
                        <h6 class="text-muted text-uppercase mb-3 font-size-xs fw-bold">Estrato Social</h6>
                        <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                            <apexchart 
                                v-if="strataOptions.xaxis.categories.length > 0"
                                class="w-100"
                                type="bar" 
                                :height="chartHeightSmall"
                                :options="strataOptions" 
                                :series="strataSeries"
                            ></apexchart>
                            <empty-state v-else icon="strata" message="Estrato social sin registrar" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import axios from 'axios';
import EmptyState from './EmptyState.vue';

const genderPalette = ['#F472B6', '#38BDF8'];
const academicPalette = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#06B6D4', '#F97316', '#14B8A6', '#84CC16', '#6366F1'];
const civilStatusPalette = ['#064E3B', '#065F46', '#047857', '#059669', '#10B981', '#34D399'];
const strataPalette = ['#431407', '#7C2D12', '#9A3412', '#C2410C', '#EA580C', '#F97316'];
const seniorityPalette = ['#ca8a04', '#eab308', '#d97706', '#b45309'];

export default {
    components: {
        apexchart: VueApexCharts,
        EmptyState
    },
    props: {
        company_id: { default: null },
    },
    data() {
        return {
            windowWidth: window.innerWidth,
            
            // --- 1. GÉNERO (Donut) ---
            genderSeries: [],
            genderOptions: {
                labels: [],
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
                legend: { position: 'bottom' },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        legend: { position: 'bottom', fontSize: '10px' }
                    }
                }]
            },

            // --- 2. NIVEL ACADÉMICO ---
            academicSeries: [{ name: 'Colaboradores', data: [] }],
            academicOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: {
                    bar: { 
                        horizontal: false,
                        borderRadius: 6,
                        distributed: true,
                        columnWidth: '60%',
                    }
                },
                colors: academicPalette,
                legend: { show: false },
                xaxis: { 
                    categories: [],
                    labels: { 
                        rotate: -45, 
                        style: { fontSize: '10px' },
                        trim: true,
                        maxHeight: 80
                    }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        plotOptions: { bar: { columnWidth: '80%' } },
                        xaxis: { labels: { rotate: -60, style: { fontSize: '8px' } } }
                    }
                }]
            },

            // --- 3. RANGOS DE EDAD ---
            ageSeries: [{ name: 'Cantidad', data: [] }],
            ageOptions: {
                chart: { type: 'area', toolbar: { show: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                colors: ['#8B5CF6'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2, stops: [0, 90, 100] }
                },
                xaxis: { 
                    categories: [],
                    labels: { style: { fontSize: '10px' } }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        xaxis: { labels: { rotate: -45, style: { fontSize: '8px' } } }
                    }
                }]
            },

            // --- 4. ESTADO CIVIL ---
            civilSeries: [{ name: 'Cantidad', data: [] }],
            civilOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: { 
                    bar: { borderRadius: 6, distributed: true } 
                },
                colors: civilStatusPalette,
                legend: { show: false },
                xaxis: { 
                    categories: [],
                    labels: { style: { fontSize: '10px' } }
                },
                responsive: [{
                    breakpoint: 768,
                    options: {
                        xaxis: { labels: { rotate: -45, style: { fontSize: '8px' } } }
                    }
                }]
            },

            // --- 5. ESTRATO SOCIAL ---
            strataSeries: [{ name: 'Cantidad', data: [] }],
            strataOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: { 
                    bar: { borderRadius: 6, distributed: true } 
                },
                colors: strataPalette,
                legend: { show: false },
                xaxis: { 
                    categories: [],
                    labels: { style: { fontSize: '10px' } }
                }
            },

            // --- 6. ANTIGÜEDAD ---
            lengthServiceSeries: [{ name: 'Colaboradores', data: [] }],
            lengthServiceOptions: {
                chart: { type: 'bar', toolbar: { show: false } },
                plotOptions: {
                    bar: { 
                        horizontal: true,
                        borderRadius: 6, 
                        distributed: true,
                        barHeight: '50%'
                    }
                },
                colors: seniorityPalette,
                legend: { show: false },
                xaxis: { categories: [] },
                yaxis: {
                    labels: { style: { fontSize: '10px' } }
                }
            }
        };
    },
    computed: {
        chartHeight() {
            return this.windowWidth < 576 ? 250 : 300;
        },
        chartHeightSmall() {
            return this.windowWidth < 576 ? 200 : 250;
        }
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
        if (this.company_id) {
            this.loadAllData(this.company_id);
        }
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.handleResize);
    },
    watch: {
        company_id(newVal) {
            if(newVal) this.loadAllData(newVal);
        }
    },
    methods: {
        handleResize() {
            this.windowWidth = window.innerWidth;
        },
        
        loadAllData(id) {
            this.getGenderData(id);
            this.getAcademicLevelData(id);
            this.getAgeRangesData(id);
            this.getCivilStatusData(id);
            this.getSocialStrataData(id);
            this.getLengthServiceData(id);
        },

        getGenderData(company_id) {
            axios.get(`/gender-data/${company_id}`).then(response => {
                const data = response.data.gender_data;
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
                this.academicSeries = [{ name: 'Empleados', data: data.values }];
                this.academicOptions = {
                    ...this.academicOptions,
                    xaxis: { ...this.academicOptions.xaxis, categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getAgeRangesData(company_id) {
            axios.get(`/age-ranges-data/${company_id}`).then(response => {
                const data = response.data.age_ranges_data;
                this.ageSeries = [{ name: 'Empleados', data: data.values }];
                this.ageOptions = {
                    ...this.ageOptions,
                    xaxis: { ...this.ageOptions.xaxis, categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getCivilStatusData(company_id) {
            axios.get(`/civil-status-data/${company_id}`).then(response => {
                const data = response.data.civil_status_data;
                this.civilSeries = [{ name: 'Empleados', data: data.values }];
                this.civilOptions = {
                    ...this.civilOptions,
                    xaxis: { ...this.civilOptions.xaxis, categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getSocialStrataData(company_id) {
            axios.get(`/social-strata-data/${company_id}`).then(response => {
                const data = response.data.social_strata_data;
                this.strataSeries = [{ name: 'Empleados', data: data.values }];
                this.strataOptions = {
                    ...this.strataOptions,
                    xaxis: { ...this.strataOptions.xaxis, categories: data.labels }
                };
            }).catch(e => console.error(e));
        },

        getLengthServiceData(company_id) {
            axios.get(`/length-service-data/${company_id}`).then(response => {
                const data = response.data.length_service_data;
                this.lengthServiceSeries = [{ name: 'Empleados', data: data.values }];
                this.lengthServiceOptions = {
                    ...this.lengthServiceOptions,
                    xaxis: { ...this.lengthServiceOptions.xaxis, categories: data.labels }
                };
            }).catch(e => console.error(e));
        }
    }
};
</script>

<style scoped>
.card {
    transition: transform 0.2s;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25) !important;
}

.font-size-xs {
    font-size: 0.85rem;
    letter-spacing: 0.05em;
}

.rounded-lg {
    border-radius: 0.75rem !important;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .font-size-xs {
        font-size: 0.8rem;
    }
}

@media (max-width: 575.98px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .font-size-xs {
        font-size: 0.75rem;
    }
}
</style>