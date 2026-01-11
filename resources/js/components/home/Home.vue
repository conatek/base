<template>
    <div>
        <MasterHome v-if="hasRole('Master')"
            :company_id="company_id"
        ></MasterHome>
        <SuperHome v-else-if="hasRole('Super')"
            :company_id="company_id"
        ></SuperHome>
        <AdminHome v-else-if="hasRole('Admin')"
            :company_id="company_id"
        ></AdminHome>
        <DefaultHome v-else
            :company_id="company_id"
        ></DefaultHome>
    </div>
</template>

<script>

import MasterHome from './MasterHome.vue'
import SuperHome from './SuperHome.vue'
import AdminHome from './AdminHome.vue'
import DefaultHome from './DefaultHome.vue'

export default {
    name: 'Home',
    components: {
        MasterHome,
        SuperHome,
        AdminHome,
        DefaultHome
    },
    props: {
        company_id: {
            type: Number,
            default: null
        },
        roles: {
            type: Array,
            default: () => []
        },
    },
    data() {
        return {
            // variables reactivas
        };
    },
    mounted() {
        // lógica al montar el componente

        // if (this.$can('block_company')) {
        //     console.log("Permiso concedido");
        // } else {
        //     console.log("Permiso denegado");
        // }
    },
    methods: {
        hasRole(role) {
            return this.roles.includes(role)
        },
        hasPermission(permission) {
            return this.permissions.includes(permission)
        }
    },
};
</script>

<style scoped>
/* estilos del componente */
</style>
