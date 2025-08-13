<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-address-card" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Mi Perfil
                    </div>
                </div>
                <!-- <div class="page-title-actions">
                    <button @click="addCompany()" class="btn btn-mh-dark-blue me-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div> -->
            </div>
        </div>

        <div v-if="message !== ''" class="message-success mb-3">
            <div class="content d-flex align-items-start p-2">
                <p class="mb-0" style="font-size: 14px;"> {{ this.message }}</p>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <form @submit.prevent="updateUser" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input v-model="name" name="name" id="name" type="text" class="form-control" placeholder="Ingresa el nombre del ususario" autofocus>
                                <span v-if="errors && errors.name" class="error text-danger" for="name">{{ errors.name[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input v-model="email" name="email" id="email" type="email" class="form-control" placeholder="Ingresa el correo electrónico" autocomplete="new-password">
                                <span v-if="errors && errors.email" class="error text-danger" for="email">{{ errors.email[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative mb-3">
                                <label for="image" class="form-label">Imagen</label>
                                <div class="input-group">
                                    <input @change="onChangeImage" type="file" name="image" id="image" class="form-control">
                                </div>
                                <span v-if="errors && errors.image" class="error text-danger" for="image">{{ errors.image[0] }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input v-model="password" name="password" id="password" type="password" class="form-control" placeholder="Ingresa la contraseña solo si la deseas modificar" autocomplete="new-password">
                                <span v-if="errors && errors.password" class="error text-danger" for="password">{{ errors.password[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="mt-2 btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'UserProfile',
    props: {
        user: {
            default: null,
        },
        roles: {
            default: null,
        },
    },
    data() {
        return {
            name: '',
            email: '',
            image: null,
            password: null,

            message: '',
            errors: null,
        };
    },
    mounted() {
        // console.log(this.roles);
    },
    watch: {
        user: {
            immediate: true,
            handler(newUser) {
                if (newUser) {
                    this.name = newUser.name || '';
                    this.email = newUser.email || '';
                }
            }
        }
    },
    methods: {
        getMessage(msg) {
            if(msg != '' && msg != null) {
                this.message = msg
            }

            setTimeout(() => {
                this.resetForm();
            }, 5000)
        },
        onChangeImage(e) {
            this.image = e.target.files[0]
        },
        updateUser() {
            let fd = new FormData()

            fd.append('company_id', this.user.company_id)
            fd.append('name', this.name)
            fd.append('email', this.email)
            if (this.image) {
                fd.append('image', this.image);
            }
            if (this.password) {
                fd.append('password', this.password);
            }
            this.roles.forEach((role, index) => {
                fd.append(`roles[${index}]`, role);
            });
            fd.append('_method', 'PUT')

            axios.post(`/users/${this.user.id}`, fd).then(
                (res) => {
                    this.getMessage(res.data.message)
                    this.user = res.data.user

                    this.errors = null
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        resetForm() {
            // this.name = '';
            // this.email = '';
            this.image = null;
            this.password = null;

            this.message = '';
            this.errors = null;
        },
    },
    computed: {
        // Definir propiedades computadas aquí
    },
};
</script>

<style scoped>
/* Estilos del componente */
</style>
