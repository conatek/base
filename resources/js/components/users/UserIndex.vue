<template>
    <div>
        <Teleport to="body">
            <div v-if="is_loading" class="loading-overlay">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Procesando...</span>
                </div>
                <p class="loading-text mt-3">Procesando, por favor espera...</p>
            </div>
        </Teleport>
        <div class="app-page-title">
            <div v-if="selected_user == null && add_user == false && edit_user == false" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-users" style="color: rgb(18, 124, 179)"></i>
                    </div>
                    <div>Listado de Usuarios</div>
                </div>
                <div class="page-title-actions">
                    <button @click="addUser()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i> Agregar
                    </button>
                </div>
            </div>
            <div v-else-if="selected_user == null && add_user == true && edit_user == false" class="page-title-wrapper">
                 <div class="page-title-heading">
                    <div class="page-title-icon"><i class="fa fa-user-plus" style="color: rgb(18, 124, 179)"></i></div>
                    <div>Agregar Usuario</div>
                </div>
                <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i> Volver al listado
                    </button>
                </div>
            </div>
            <div v-else-if="selected_user != null && add_user == false && edit_user == true" class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon"><i class="pe-7s-users text-success"></i></div>
                    <div>Editar Usuario</div>
                </div>
                 <div class="page-title-actions">
                    <button @click="returnToList()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-arrow-left"></i> Volver al listado
                    </button>
                </div>
            </div>
        </div>

        <!-- <div v-if="origin === 'created'" class="message-success mb-3">
            <div class="content d-flex align-items-start p-2"><p class="mb-0">Usuario creado exitosamente</p></div>
        </div>
        <div v-if="origin === 'updated'" class="message-success mb-3">
            <div class="content d-flex align-items-start p-2"><p class="mb-0">Usuario actualizado exitosamente</p></div>
        </div>
        <div v-if="origin === 'deleted'" class="message-success mb-3">
            <div class="content d-flex align-items-start p-2"><p class="mb-0">Usuario eliminado exitosamente</p></div>
        </div> -->

        <div v-if="selected_user == null && add_user == false && edit_user == false" class="main-card mb-3 card">
            <div class="card-body table-responsive">
                <vue-good-table
                    :columns="columns"
                    :rows="rows"
                    :search-options="{
                        enabled: true,
                        placeholder: 'Buscar...',
                        trigger: 'immediate'
                    }"
                    :pagination-options="{
                        enabled: true,
                        perPage: 5,
                        perPageDropdown: [5, 10, 20],
                        dropdownAllowAll: false,
                        mode: 'records',
                        nextLabel: 'Siguiente',
                        prevLabel: 'Anterior',
                        rowsPerPageLabel: 'Filas',
                        ofLabel: 'de',
                        pageLabel: 'Página',
                        allLabel: 'Todo'
                    }"
                    :style-class="'vgt-table bordered condensed'"
                    :no-data-message="'No hay resultados que coincidan'"
                >
                    <template #table-row="props">
                        <span v-if="props.column.field === 'actions'">
                            <template v-if="props.row && canEdit(props.row)">
                                <button @click="editUser(props.row.id)" class="btn-icon btn btn-sm btn-primary me-2">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                                <button @click="showDeleteAlert(props.row.id, props.index)" class="btn-icon btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </template>
                            <template v-else>
                                <span class="text-muted small">Sin acciones disponibles</span>
                            </template>
                        </span>

                        <span v-else-if="props.column.field === 'roles'">
                            <div v-if="props.row.roles && props.row.roles.length > 0">
                                <div v-for="role in props.row.roles" :key="role.id" class="d-inline-block me-1">
                                    <span class="badge bg-success">{{ role.name }}</span>
                                </div>
                            </div>
                            <div v-else>
                                <span class="badge bg-danger">Sin rol</span>
                            </div>
                        </span>

                        <span v-else>
                            {{ props.formattedRow[props.column.field] }}
                        </span>
                    </template>
                </vue-good-table>
            </div>
        </div>

        <div v-else-if="selected_user == null && add_user == true && edit_user == false" class="main-card mb-3 card">
             <div class="card-body">
                <form @submit.prevent="storeUser" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="name" class="form-label">Nombres</label>
                                <input v-model="name" id="name" type="text" class="form-control" placeholder="Nombres">
                                <span v-if="errors && errors.name" class="error text-danger">{{ errors.name[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="first_surname" class="form-label">Primer Apellido</label>
                                <input v-model="first_surname" id="first_surname" type="text" class="form-control" placeholder="Primer Apellido">
                                <span v-if="errors && errors.first_surname" class="error text-danger">{{ errors.first_surname[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="second_surname" class="form-label">Segundo Apellido</label>
                                <input v-model="second_surname" id="second_surname" type="text" class="form-control" placeholder="Segundo Apellido (Opcional)">
                                <span v-if="errors && errors.second_surname" class="error text-danger">{{ errors.second_surname[0] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input v-model="email" name="email" id="email" type="email" class="form-control" placeholder="Ingresa el correo electrónico" autocomplete="new-password">
                                <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="image" class="form-label">Imagen</label>
                                <input
                                    ref="imageFileInput"
                                    type="file"
                                    accept=".jpg, .jpeg, .png"
                                    class="form-control d-none"
                                    @change="onChangeImage"
                                >
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary" @click="selectImageFile">
                                        <i class="fa fa-upload"></i> Seleccionar
                                    </button>
                                    <input
                                        @click="selectImageFile"
                                        type="text"
                                        class="form-control"
                                        :value="image ? image.name : ''"
                                        readonly
                                        placeholder="Sin archivo"
                                    />
                                </div>
                                <div v-if="image_src" class="cropper-container">
                                    <cropper
                                        ref="cropperRef"
                                        :src="image_src"
                                        :stencil-props="{ aspectRatio: 1/1 }"
                                    />
                                </div>
                                <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input v-model="password" name="password" id="password" type="password" class="form-control" placeholder="Ingresa la contraseña" autocomplete="new-password">
                                <span v-if="errors && errors.password" class="error text-danger" for="password">{{ errors.password[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Guardar</button>
                    <hr>
                    <p>Asignar Roles</p>
                    <div v-if="roles" class="row">
                        <div v-for="role in filteredRoles" :key="role.id" class="col-lg-3 col-md-4 col-sm-6 py-1">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" :id="'checkbox_' + role.name"
                                        :value="role.name" v-model="selected_roles">
                                    <label :for="'checkbox_' + role.name">{{ role.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span v-if="errors && errors.roles" class="error text-danger" for="roles">{{ errors.roles[0] }}</span>
                </form>
            </div>
        </div>

        <div v-else-if="selected_user != null && add_user == false && edit_user == true && userData">
            <div class="col-md-12">
                <div class="card-shadow-primary card-border text-white mb-3 card bg-primary">
                    <div class="card-body mx-auto">
                        <div class="avatar-icon-wrapper avatar-icon-xl d-flex mb-3 justify-content-center">
                            <div class="avatar-icon">
                                <img
                                    :src="userData.image_url ? userData.image_url : '/images/default-profile.jpeg'"
                                    :alt="userData.name ? userData.name : 'Perfil predeterminado'">
                            </div>
                        </div>
                        <div>
                            <h5 class="menu-header-title text-center">{{ userData.name }}</h5>
                            <h6 class="menu-header-subtitle text-center">{{ userData.email }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form @submit.prevent="updateUser" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="name" class="form-label">Nombres</label>
                                    <input v-model="name" type="text" class="form-control" placeholder="Ingrese nombres" autofocus>
                                    <span v-if="errors?.name" class="error text-danger">{{ errors.name[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="first_surname" class="form-label">Primer Apellido</label>
                                    <input v-model="first_surname" type="text" class="form-control" placeholder="Ingrese primer apellido">
                                    <span v-if="errors?.first_surname" class="error text-danger">{{ errors.first_surname[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="second_surname" class="form-label">Segundo Apellido</label>
                                    <input v-model="second_surname" type="text" class="form-control" placeholder="Ingrese segundo apellido">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input v-model="email" name="email" id="email" type="email" class="form-control" placeholder="Ingrese email">
                                    <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="image" class="form-label">Imagen</label>
                                    <input
                                        ref="imageFileInput"
                                        type="file"
                                        accept=".jpg, .jpeg, .png"
                                        class="form-control d-none"
                                        @change="onChangeImage"
                                    >
                                    <div class="input-group">
                                        <button type="button" class="btn btn-primary" @click="selectImageFile">
                                            <i class="fa fa-upload"></i> Seleccionar
                                        </button>
                                        <input
                                            @click="selectImageFile"
                                            type="text"
                                            class="form-control"
                                            :value="image ? image.name : ''"
                                            readonly
                                            placeholder="Sin archivo"
                                        />
                                    </div>
                                    <div v-if="image_src" class="cropper-container">
                                        <cropper
                                            ref="cropperRef"
                                            :src="image_src"
                                            :stencil-props="{ aspectRatio: 1/1 }"
                                        />
                                    </div>
                                    <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input v-model="password" name="password" id="password" type="password" class="form-control" placeholder="Ingrese la contraseña solo si desea modificar">
                                    <span v-if="errors && errors.password" class="error text-danger" for="password">{{ errors.password[0] }}</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="mt-2 btn btn-primary">Actualizar</button>
                        <hr>
                        <p>Asignar Roles</p>
                        <div v-if="roles" class="row">
                            <div v-for="role in filteredRoles" :key="role.id" class="col-lg-3 col-md-4 col-sm-6 py-1">
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" :id="'checkbox_' + role.name"
                                            :value="role.name" v-model="selected_roles">
                                        <label :for="'checkbox_' + role.name">{{ role.name }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span v-if="errors && errors.roles" class="error text-danger" for="roles">{{ errors.roles[0] }}</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { VueGoodTable } from 'vue-good-table-next';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
    components: {
        VueGoodTable,
        Cropper,
    },
    props: {
        current_user_id: { default: null },
        current_user_roles: { default: null },
        company_id: { default: null },
        roles: { default: null },
    },
    data() {
        return {
            is_loading: false,
            users: [],
            fetchedRoles: [],
            selected_user: null,
            add_user: false,
            edit_user: false,
            userData: null,
            selected_roles: [],
            rolePriority: {
                'Master': 1,
                'Super': 2,
                'Admin': 3
            },
            name: '',
            first_surname: '',
            second_surname: '',
            email: '',

            // Variables de Imagen
            image: null,      // Para guardar el archivo original y mostrar el nombre
            image_src: null,  // URL local para el cropper

            password: null,
            errors: null,
            // message: '',
            // successfully_created_message: false,
            // successfully_updated_message: false,
            // successfully_deleted_message: false,
            // origin: '',

            // Nuevas propiedades
            columns: [],
            rows: [],
        };
    },
    mounted() {
        this.getUsers();
        this.fetchRolesData();
    },
    watch: {
        userData: {
            immediate: true,
            handler(newUserData) {
                if (newUserData?.roles) {
                    this.selected_roles = newUserData.roles.map(role => role.name);
                }
            }
        },
        users: {
            handler() {
                if(this.users.length > 0) {
                    this.columns = [
                        // Cambiamos 'name' por 'full_name' que creamos en el controlador
                        { label: 'Nombre Completo', field: 'full_name' },
                        { label: 'Email', field: 'email' },
                        { label: 'Roles', field: 'roles', sortable: false },
                        { label: 'Acciones', field: 'actions', sortable: false, tdClass: 'align-right', thClass: 'align-right' },
                    ];
                    this.rows = this.users;
                }
            },
        },
    },
    computed: {
        filteredRoles() {
            const hierarchy = ['Master', 'Super', 'Admin'];
            const userRole = hierarchy.find(role => this.current_user_roles.includes(role));

            if (!userRole) {
                return [];
            }

            let exclude = [];
            switch (userRole) {
                case 'Super':
                    exclude = ['Master', 'Super'];
                    break;
                case 'Admin':
                    exclude = ['Master', 'Super', 'Admin'];
                    break;
                default:
                    exclude = [];
            }
            const allRoles = this.roles || this.fetchedRoles;
            return allRoles.filter(role => !exclude.includes(role.name));
        }
    },
    methods: {
        selectImageFile() {
            this.$refs.imageFileInput.click();
        },
        onChangeImage(e) {
            const file = e.target.files[0];
            this.image = file; // Para mostrar el nombre en el input text

            if (file) {
                // Creamos una URL local para que el cropper la muestre
                this.image_src = URL.createObjectURL(file);
            } else {
                this.image_src = null;
            }
        },

        showDeleteAlert(item, index) {
            this.$swal({
                title: "¿Seguro que deseas eliminar este registro?",
                text: "¡No podrás revertir esto!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3f6ad8",
                cancelButtonColor: "#444054",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "Cancelar",
            }).then((result) => {
            if (result.isConfirmed) {
                this.deleteUser(item, index)
                this.$swal({
                    title: "Eliminado!",
                    text: "Su registro ha sido borrado.",
                    icon: "success"
                });
            }
            });
        },
        // getMessage(msg) {
        //     if(msg != '' && msg != null) {
        //         this.message = msg
        //     }

        //     setTimeout(() => {
        //         this.message = ''
        //         this.successfully_created_message = false
        //         this.successfully_updated_message = false
        //         this.successfully_deleted_message = false
        //     }, 3000)
        // },
        // getOrigin() {
        //     const origin = localStorage.getItem('origin');
        //     if (origin !== null) {
        //         this.origin = origin;
        //         localStorage.removeItem('origin');
        //     }
        //     setTimeout(() => {
        //         this.origin = '';
        //     }, 3000);
        // },
        returnToList() {
            this.selected_user = null
            this.add_user = false
            this.edit_user = false

            // Limpiar variables de imagen
            this.image = null
            this.image_src = null
        },
        fetchRolesData() {
            axios.get('/get-roles').then((res) => {
                this.fetchedRoles = res.data.roles || [];
            }).catch(() => {});
        },
        getUsers() {
            axios.get(`/users-data/${this.company_id}`).then(
                (res) => {
                    this.users = res.data.users;
                    this.errors = null;
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        addUser() {
            this.selected_user = null;
            this.add_user = true;
            this.edit_user = false;

            this.name = '';
            this.first_surname = ''; // <--- LIMPIAR
            this.second_surname = ''; // <--- LIMPIAR
            this.email = '';
            this.image = null;
            this.image_src = null;
            this.password = '';
            this.selected_roles = [];
        },

        storeUser() {
            this.is_loading = true; // ACTIVAR AL INICIO

            let fd = new FormData();

            // Función interna
            const sendRequest = (formData) => {
                this.appendIfNotEmpty(formData, 'company_id', this.company_id);
                this.appendIfNotEmpty(formData, 'name', this.name);
                this.appendIfNotEmpty(formData, 'first_surname', this.first_surname);
                this.appendIfNotEmpty(formData, 'second_surname', this.second_surname ? this.second_surname : '');
                this.appendIfNotEmpty(formData, 'email', this.email);
                this.appendIfNotEmpty(formData, 'password', this.password);

                this.selected_roles.forEach((role, index) => {
                    formData.append(`roles[${index}]`, role);
                });

                axios.post('/users', formData).then(
                    (res) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: '¡Usuario Creado!',
                            text: 'El usuario ha sido registrado exitosamente.',
                            confirmButtonColor: '#127cb3', // Color de referencia
                            timer: 2000
                        });

                        // this.getMessage(res.data.message)
                        this.getUsers();
                        this.returnToList();
                        this.errors = null
                    }).catch((error) => {
                        // ERROR
                        if (error.response && error.response.status === 422) {
                            // Errores de validación
                            this.errors = error.response.data.errors;
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Datos incompletos',
                                text: 'Por favor revisa el formulario, hay campos obligatorios pendientes o inválidos.',
                                confirmButtonColor: '#d33'
                            });
                        } else {
                            // Otros errores
                            console.error(error);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Error del servidor',
                                text: error.response?.data?.message || 'Ocurrió un error inesperado.'
                            });
                        }
                    }).finally(() => {
                        this.is_loading = false; // Desactivar loading
                    });
            };

            // Lógica del Cropper
            if (this.$refs.cropperRef && this.image_src) {
                const { canvas } = this.$refs.cropperRef.getResult();
                if (canvas) {
                    const resizedCanvas = document.createElement('canvas');
                    resizedCanvas.width = 300;
                    resizedCanvas.height = 300;
                    const ctx = resizedCanvas.getContext('2d');
                    ctx.drawImage(canvas, 0, 0, 300, 300);

                    resizedCanvas.toBlob((blob) => {
                        fd.append('image', blob, 'profile_300x300.png');
                        sendRequest(fd);
                    }, 'image/png');
                } else {
                    if (this.image) fd.append('image', this.image);
                    sendRequest(fd);
                }
            } else {
                sendRequest(fd);
            }
        },

        canEdit(user) {
            if (user.id === this.current_user_id) return false;
            if (!user.roles || user.roles.length === 0) return true;
            const currentRoleLevel = Math.min(...this.current_user_roles.map(r => this.rolePriority[r] || 99));
            const targetRoleLevel = Math.min(...user.roles.map(r => this.rolePriority[r.name] || 99));
            return currentRoleLevel < targetRoleLevel;
        },
        editUser(userId) { // Nota: Tu template pasa el ID, no el objeto entero en el click
            this.selected_user = this.users.find(u => u.id === userId);
            this.add_user = false;
            this.edit_user = true;

            this.image = null;
            this.image_src = null;

            // Cargar datos locales antes de la petición para UX rápida
            this.name = this.selected_user.name;
            this.first_surname = this.selected_user.first_surname; // <--- CARGAR
            this.second_surname = this.selected_user.second_surname; // <--- CARGAR
            this.email = this.selected_user.email;

            // Petición para datos frescos (opcional si ya tienes todo en selected_user)
            axios.get(`/users/${userId}/edit`).then((res) => {
                this.userData = res.data.user;
                // Asegurar integridad con la BD
                this.name = this.userData.name;
                this.first_surname = this.userData.first_surname;
                this.second_surname = this.userData.second_surname;
                this.email = this.userData.email;
                this.errors = null;
            }).catch((error) => { /* ... */ });
        },

        updateUser() {
            this.is_loading = true;
            let fd = new FormData();

            const sendRequest = (formData) => {
                this.appendIfNotEmpty(formData, 'company_id', this.company_id);
                this.appendIfNotEmpty(formData, 'name', this.name);
                this.appendIfNotEmpty(formData, 'first_surname', this.first_surname);
                // this.appendIfNotEmpty(formData, 'second_surname', this.second_surname);
                formData.append('second_surname', this.second_surname ? this.second_surname : '');
                // this.appendIfNotEmpty(formData, 'second_surname', this.second_surname ? this.second_surname : '');
                this.appendIfNotEmpty(formData, 'email', this.email);
                if (this.password) formData.append('password', this.password);

                this.selected_roles.forEach((role, i) => formData.append(`roles[${i}]`, role));
                formData.append('_method', 'PUT');

                axios.post(`/users/${this.selected_user.id}`, formData)
                    .then((res) => {
                        this.$swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'La información del usuario ha sido modificada correctamente.',
                            confirmButtonColor: '#127cb3',
                            timer: 2000
                        });

                        this.getUsers();
                        this.returnToList();
                        this.errors = null;
                    }).catch((error) => {
                        // ERROR
                        if (error.response && error.response.status === 422) {
                            this.errors = error.response.data.errors;
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Datos incompletos',
                                text: 'Por favor revisa el formulario, hay campos obligatorios pendientes.',
                                confirmButtonColor: '#d33'
                            });
                        } else {
                            console.error(error);
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.response?.data?.message || 'Error al actualizar el usuario.'
                            });
                        }
                    }).finally(() => {
                        this.is_loading = false;
                    });
            };

            // Lógica del Cropper idéntica a storeUser...
            if (this.$refs.cropperRef && this.image_src) {
                const { canvas } = this.$refs.cropperRef.getResult();
                canvas.toBlob((blob) => {
                    fd.append('image', blob, 'profile.png');
                    sendRequest(fd);
                }, 'image/png');
            } else {
                sendRequest(fd);
            }
        },
        deleteUser(user) {
            this.is_loading = true; // ACTIVAR
            axios.delete(`/users/${user}`).then(
                (res) => {
                    localStorage.setItem('origin', 'deleted');
                    this.successfully_created_message = false
                    this.successfully_updated_message = false
                    this.successfully_deleted_message = true
                    this.getMessage(res.data.message)

                    this.getUsers();

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false; // DESACTIVAR
                })
        },
        appendIfNotEmpty(fd, key, value) {
            if (value !== null && value !== '' && value !== undefined) {
                fd.append(key, value)
            }
        },
    },
};
</script>

<style scoped>
    @import './../../assets/css/custom.css';

    .message-success {
        width: 100%;
        background: #D8FFDC;
        border-radius: 4px;
        padding: 10px;
    }

    .message-success .content {
        align-items: flex-start;
        justify-content: center;
        border-left: 5px solid #00660A;
    }

    .message-success .content p {
        font-size: 16px;
        line-height: 16px;
    }

    /* Estilo traido del otro componente */
    .cropper-container {
        width: 100%;
        max-width: 500px;
        margin-top: 15px;
        border: 1px solid #ccc;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.85);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-text {
        font-weight: 500;
        color: #333;
    }
</style>
