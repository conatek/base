<template>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <table style="width: 100%;" id="dt_users" class="table table-cntk table-hover table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <!-- @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td class="td-actions">
                            @can('permission_show')
                            <a href="{{ route('permissions.show', $permission->id) }}" class="mb-2 me-2 btn-icon btn btn-sm btn-success">
                                <i class="pe-7s-look btn-icon-wrapper"></i>Mostrar
                            </a>
                            @endcan

                            @can('permission_edit')
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="mb-2 me-2 btn-icon btn btn-sm btn-primary">
                                <i class="pe-7s-pen btn-icon-wrapper"></i>Editar
                            </a>
                            @endcan

                            @can('permission_destroy')
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="mb-2 me-2 btn-icon btn btn-sm btn-danger" type="submit">
                                    <i class="pe-7s-trash btn-icon-wrapper"></i>Eliminar
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach -->
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PermissionsIndex',

    data() {
        return {
            // Definir datos reactivos aquí
        };
    },
    methods: {
        // Definir métodos aquí
    },
    created() {
        // Código a ejecutar cuando el componente es creado
    }
};
</script>

<style scoped>
.permissions-index {
    /* Estilos del componente */
}
</style>
