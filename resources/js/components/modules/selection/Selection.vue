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

        <requisition-index></requisition-index>
    </div>
</template>

<script>
export default {
    name: 'Selection',
};
</script>

<style scoped>
    @import './../../../assets/css/custom.css';
</style>
