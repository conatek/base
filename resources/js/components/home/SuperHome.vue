<template>
    <div>
        <h1>Home Super {{ company_id }}</h1>
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
            // variables reactivas
        };
    },
    methods: {
        // métodos del componente
    },
    mounted() {
        // lógica al montar el componente
    }
};
</script>

<style scoped>
/* estilos del componente */
</style>
