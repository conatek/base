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
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fa fa-address-card" style="color: #127cb3;"></i>
                    </div>
                    <div>
                        Mi Perfil
                    </div>
                </div>
            </div>
        </div>

        <div v-if="message !== ''" class="message-success mb-3">
            <div class="content d-flex align-items-start p-2">
                <p class="mb-0" style="font-size: 14px;"> {{ this.message }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-shadow-primary card-border text-white mb-3 card bg-primary">
                    <div class="card-body mx-auto">
                        <div class="avatar-icon-wrapper avatar-icon-xl d-flex mb-3 justify-content-center">
                            <div class="avatar-icon">
                                <img
                                    :src="user.image_url ? user.image_url : '/images/default-profile.jpeg'"
                                    :alt="user.name ? user.name : 'Perfil predeterminado'">
                            </div>
                        </div>
                        <div>
                            <h5 class="menu-header-title text-center">{{ user.name }}</h5>
                            <h6 class="menu-header-subtitle text-center">{{ user.email }}</h6>
                        </div>

                        <!-- Contenedor modificado para centrar los badges -->
                        <div v-if="roles && roles.length > 0" class="text-center w-100 mt-2">
                            <div v-for="role in roles" :key="role.id" class="d-inline-block m-1">
                                <span class="badge bg-light">{{ role }}</span>
                            </div>
                        </div>
                        <div v-else class="text-center w-100 mt-2">
                            <span class="badge bg-light">Sin rol</span>
                        </div>
                    </div>
                </div>
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

                                <input
                                    ref="imageFileInput"
                                    @change="onChangeImage"
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="form-control d-none"
                                    accept=".jpg,.jpeg,.png"
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
                                        :stencil-props="{
                                            aspectRatio: 1/1
                                        }"
                                    />
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
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

export default {
    name: 'UserProfile',
    components: {
        Cropper,
    },
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
            is_loading: false,
            name: '',
            email: '',

            // Variables para imagen y cropper
            image: null,
            image_src: null,

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
        selectImageFile() {
            this.$refs.imageFileInput.click();
        },
        getMessage(msg) {
            if(msg != '' && msg != null) {
                this.message = msg
            }

            setTimeout(() => {
                this.resetForm();
            }, 5000)
        },
        onChangeImage(e) {
            const file = e.target.files[0];
            this.image = file;

            if (file) {
                // Creamos una URL local para que el cropper la muestre
                this.image_src = URL.createObjectURL(file);
            } else {
                this.image_src = null;
            }
        },
        updateUser() {
            this.is_loading = true;
            let fd = new FormData()

            // Función interna para enviar la petición
            const sendRequest = (formData) => {
                formData.append('company_id', this.user.company_id)
                formData.append('name', this.name)
                formData.append('email', this.email)

                if (this.password) {
                    formData.append('password', this.password);
                }

                if (this.roles) {
                    this.roles.forEach((role, index) => {
                        formData.append(`roles[${index}]`, role);
                    });
                }

                formData.append('_method', 'PUT')

                axios.post(`/users/${this.user.id}`, formData).then(
                    (res) => {
                        this.getMessage(res.data.message)
                        // this.user = res.data.user // Nota: Ten cuidado al mutar props directamente, es mejor emitir un evento, pero mantengo tu lógica original.
                        this.errors = null
                    }).catch(
                    (error) => {
                        if(error && error.response && error.response.data && error.response.data.errors) {
                            this.errors = error.response.data.errors
                        }
                    }).finally(() => {
                        this.is_loading = false;
                    })
            };

            // Lógica del Cropper y redimensionamiento
            if (this.$refs.cropperRef && this.image_src) {
                const { canvas } = this.$refs.cropperRef.getResult();

                if (canvas) {
                    // Crear un canvas de 300x300
                    const resizedCanvas = document.createElement('canvas');
                    resizedCanvas.width = 300;
                    resizedCanvas.height = 300;

                    // Dibujar y redimensionar
                    const ctx = resizedCanvas.getContext('2d');
                    ctx.drawImage(canvas, 0, 0, 300, 300);

                    // Convertir a Blob
                    resizedCanvas.toBlob((blob) => {
                        fd.append('image', blob, 'profile_300x300.png');
                        sendRequest(fd);
                    }, 'image/png');
                } else {
                    // Si falla el canvas pero hay imagen, enviar la original (fallback)
                     if (this.image) fd.append('image', this.image);
                    sendRequest(fd);
                }
            } else {
                // Si no hay nueva imagen, enviar el resto de datos
                sendRequest(fd);
            }
        },
        resetForm() {
            // this.name = '';
            // this.email = '';
            this.image = null;
            this.image_src = null; // Limpiar el cropper
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
.cropper-container {
    width: 100%;
    max-width: 500px;
    margin-top: 15px;
    border: 1px solid #ccc;
}

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
