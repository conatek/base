<template>
    <div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <!-- <form> -->
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Carga Masiva de Colaboradores
                                </div>

                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <!-- <div class="col-sm-12 col-md-8 mb-3"> -->
                                        <div class="col-12 mb-3">
                                            <div class="position-relative">
                                                <input
                                                    ref="fileInput"
                                                    type="file"
                                                    accept=".xlsx, .xls"
                                                    class="form-control d-none"
                                                    @change="handleFile"
                                                >
                                                <!-- <span v-if="errors && errors.logo" class="error text-danger" for="logo">{{ errors.logo[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="file != '' ? file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-12 col-md-4 mb-3 d-flex align-items-end"> -->
                                        <div class="col-12 mb-3 d-flex align-items-end">
                                            <a
                                                type="button"
                                                class="btn btn-success"
                                                href="/download/carga-masiva-colaboradores.xlsx"
                                                >
                                                <font-awesome-icon :icon="['fas', 'download']" />
                                                Descargar Plantilla
                                            </a>
                                        </div>
                                        <div class="form-text">
                                            Carga un archivo Excel con la plantilla descargada para agregar colaboradores a la empresa.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Procesar Archivo</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CompanyCollaborators',
    props: {
        company_id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            file: '',
            fileName: '',
        };
    },
    mounted() {
        // Add your mounted logic here
    },
    methods: {
        selectFile() {
            this.$refs.fileInput.click();
            console.log(this.file);
        },
        handleFile(e) {
            this.file = e.target.files[0];
            this.fileName = this.file ? this.file.name : '';
        },
        submit(){
            const formData = new FormData();

            formData.append('company_id', this.company_id);
            formData.append('file', this.file);

            axios.post(`/collaborators/import`, formData).then(
                (res) => {
                    console.log(res.data.message);
                    // this.selectsDataCreate = res.data
                    // this.errors = null
                }).catch(
                (error) => {
                    console.error('Error importing collaborators:', error);
                    // if(error && error.response && error.response.data && error.response.data.errors) {
                    //     this.errors = error.response.data.errors
                    // }
                })
        },
    },
};
</script>

<style scoped>
/* Add your component styles here */
</style>
