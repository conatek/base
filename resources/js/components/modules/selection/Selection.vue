<template>
    <div class="container-fluid">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <!-- <i class="pe-7s-user text-success"></i> -->
                        <i class="fa fa-user-check" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Procesos de Selección
                    </div>
                </div>
                <!-- <div class="page-title-actions">
                    <button @click="addRequisition()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div> -->
            </div>
        </div>

        <requisition-index
            :requisitions="requisitions"
            :requisition_types="requisition_types"
            :collaborators="collaborators"
            :campuses="campuses"
            :areas="areas"
            :positions="positions"
            :reasons="reasons"
            :statuses="statuses"
            :sources="sources"
        ></requisition-index>
    </div>
</template>

<script>
export default {
    name: 'Selection',
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
        requisitions: {
            default: null,
        },
    },
    data() {
        return {
            // Your component data here
        };
    },
    mounted() {
        // Lifecycle hook
    },
    methods: {
        // Your component methods here
    },
};
</script>

<style scoped>
    @import './../../../assets/css/custom.css';
</style>
