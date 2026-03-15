<template>
    <div class="login-wrapper">

        <div class="col-lg-5 col-xl-4 login-brand-side">
            <div class="brand-bg-image"></div>
            <div class="brand-blob"></div>
            <div class="brand-content text-center text-lg-start">
                <h2 class="display-6 fw-bold mb-3">Nueva contraseña</h2>
                <p class="lead fw-light mb-4 d-none d-lg-block">
                    Elige una contraseña segura para proteger tu cuenta.
                </p>
            </div>
        </div>

        <div class="col-lg-7 col-xl-8 login-form-side">
            <div class="login-card">

                <div class="text-center">
                    <img :src="'/images/logo-mh.svg'" alt="Muy Humano Logo" class="mh-logo-img">
                </div>

                <h1 class="welcome-text">Restablecer contraseña</h1>
                <p class="subtitle-text">Ingresa tu nueva contraseña a continuación.</p>

                <form @submit.prevent="handleSubmit">

                    <div class="mb-3">
                        <input type="hidden" v-model="form.token">
                        <label for="email" class="form-label visually-hidden">Correo electrónico</label>
                        <input id="email"
                               type="email"
                               class="form-control"
                               :class="{ 'is-invalid': errors.email }"
                               v-model="form.email"
                               required
                               autocomplete="email"
                               placeholder="nombre@empresa.com">
                        <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
                    </div>

                    <div class="mb-3">
                        <input id="password"
                               type="password"
                               class="form-control"
                               :class="{ 'is-invalid': errors.password }"
                               v-model="form.password"
                               required
                               placeholder="Nueva contraseña">
                        <div v-if="errors.password" class="invalid-feedback">{{ errors.password[0] }}</div>
                    </div>

                    <div class="mb-3">
                        <input id="password_confirmation"
                               type="password"
                               class="form-control"
                               v-model="form.password_confirmation"
                               required
                               placeholder="Confirmar contraseña">
                    </div>

                    <div v-if="generalError" class="alert alert-danger mb-3 py-2">
                        {{ generalError }}
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <span v-if="loading">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Guardando...
                            </span>
                            <span v-else>Guardar contraseña</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'ResetPasswordPage',

    data() {
        return {
            form: {
                token: this.$route.params.token || '',
                email: this.$route.query.email || '',
                password: '',
                password_confirmation: '',
            },
            errors: {},
            generalError: '',
            loading: false,
        };
    },

    methods: {
        async handleSubmit() {
            this.errors = {};
            this.generalError = '';
            this.loading = true;

            try {
                await window.axios.post('/reset-password', this.form);
                this.$router.push({ path: '/login', query: { reset: 'success' } });
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.generalError = 'Error al restablecer la contraseña. Intenta de nuevo.';
                }
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.login-wrapper { min-height: 100vh; width: 100%; display: flex; overflow: hidden; font-family: 'Outfit', sans-serif; }
.login-brand-side { background-color: #12b338; position: relative; display: flex; flex-direction: column; justify-content: center; padding: 4rem; color: white; overflow: hidden; }
.brand-bg-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('/images/sidebar/mh-people-lineart.jpg'); background-size: cover; background-position: center; opacity: 0.15; z-index: 0; }
.brand-blob { position: absolute; top: -10%; right: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; z-index: 1; }
.brand-content { position: relative; z-index: 2; }
.login-form-side { background: white; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; }
.login-card { width: 100%; max-width: 420px; padding: 2rem; }
.mh-logo-img { max-width: 180px; margin: 0 auto 2rem; display: block; }
.welcome-text { font-size: 1.75rem; font-weight: 700; color: #12b338; text-align: center; margin-bottom: 0.5rem; }
.subtitle-text { color: #6B7280; text-align: center; margin-bottom: 2rem; font-weight: 300; }
.form-control { background-color: #F3F4F6; border: 2px solid transparent; border-radius: 12px; padding: 0.8rem 1rem; transition: all 0.3s ease; }
.form-control:focus { background-color: white; border-color: #12b338; box-shadow: 0 0 0 4px rgba(18, 179, 56, 0.1); }
.btn-primary { background-color: #12b338; border: none; border-radius: 50px; padding: 0.8rem 2rem; font-weight: 600; width: 100%; margin-top: 1rem; transition: transform 0.2s; }
.btn-primary:hover { background-color: #1B5E20; transform: translateY(-2px); }
.btn-primary:disabled { background-color: #9CA3AF; transform: none; }
@media (max-width: 991px) { .login-wrapper { flex-direction: column; } .login-brand-side { min-height: 200px; padding: 2rem; flex: 0 0 auto; } }
</style>
