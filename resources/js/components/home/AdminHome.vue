<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="metismenu-icon fa fa-chart-line" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Panel de Control
                    </div>
                </div>
            </div>
        </div>
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a @click="changeTab(0)" role="tab" class="nav-link active" id="tab-0"
                    data-bs-toggle="tab"  href="#tab-content-0">
                    <span>Perfil Sociodemográfico</span>
                </a>
            </li>
            <li class="nav-item">
                <a @click="changeTab(1)" role="tab" class="nav-link" id="tab-1"
                    data-bs-toggle="tab" href="#tab-content-1">
                    <span>Alertas</span>
                </a>
            </li>
            <li class="nav-item">
                <a @click="changeTab(2)" role="tab" class="nav-link" id="tab-2"
                    data-bs-toggle="tab" href="#tab-content-2">
                    <span>Indicadores</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div v-if="selected_tab == 0" class="tab-pane tabs-animation fade" :class="selected_tab == 0 ? 'show active' : ''" id="tab-content-0" role="tabpanel">
                <sociodemographic-profile :company_id="company_id"></sociodemographic-profile>
            </div>
            <div v-else-if="selected_tab == 1" class="tab-pane tabs-animation fade"  :class="selected_tab == 1 ? 'show active' : ''" id="tab-content-1" role="tabpanel">
                <alerts :company_id="company_id"></alerts>
            </div>
            <div v-else-if="selected_tab == 2" class="tab-pane tabs-animation fade"  :class="selected_tab == 2 ? 'show active' : ''" id="tab-content-2" role="tabpanel">
                <indicators :company_id="company_id"></indicators>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Home',
    props: {
        company_id: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            selected_tab: 0,
        };
    },
    mounted() {
        this.changeTab(0);
    },
    methods: {
        changeTab(tabIndex) {
            this.selected_tab = tabIndex;
        }
    },
};
</script>

<style scoped>
/* estilos del componente */
</style>
