<template>
    <div class="colaborator-absence">
        <div v-if="collaborator" class="main-card mb-3 card">
            <div class="card-body table-responsive">
                <table style="width: 100%;" id="dt_absences" class="table table-cntk table-hover table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Inicio</th>
                            <th class="text-center">Finalización</th>
                            <th class="text-center">Vigencia</th>
                            <th class="text-center">Contingencia</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Segmento</th>
                            <th class="text-center">Días</th>
                            <th class="text-center">Horas</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr v-for="(user, index) in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.company.company_name }}</td>
                            <td class="text-center">
                                <div v-for="role in user.roles" :key="role.id">
                                    <span v-if="role" class="badge bg-success" style="min-width: 100px;">{{ role.name }}</span>
                                    <span v-else class="badge bg-danger" style="min-width: 100px;">Sin rol</span>
                                </div>
                            </td>
                            <td class="align-middle text-end">
                                <button v-if="user" @click="editUser(user.id)" class="me-2 btn-icon btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button v-if="user" @click="showDeleteAlert(user.id, index)" class="btn-icon btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr> -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">Inicio</th>
                            <th class="text-center">Finalización</th>
                            <th class="text-center">Vigencia</th>
                            <th class="text-center">Contingencia</th>
                            <th class="text-center">Descripción</th>
                            <th class="text-center">Segmento</th>
                            <th class="text-center">Días</th>
                            <th class="text-center">Horas</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

import { absencesDatatable } from '../../assets/js/tables.js';

export default {
    name: 'CollaboratorAbsence',
    props: {
        collaborator: {
            default: null,
        },
    },
    data() {
        return {
            // Your component data here
        };
    },
    mounted() {
        absencesDatatable();
    },
    methods: {
        // Your component methods here
    },
};
</script>

<style scoped>
/* Your component styles here */
</style>
