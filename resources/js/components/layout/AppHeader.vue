<template>
    <div class="app-header header-shadow" style="border-bottom: 4px solid #ff4600;">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ms-auto">
                <div>
                    <button type="button"
                            class="hamburger close-sidebar-btn hamburger--elastic"
                            data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>

        <div class="app-header__menu">
            <span>
                <button type="button"
                        class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>

        <div class="app-header__content">
            <div class="app-header-left">
                <!-- Aviso de impersonación -->
                <div v-if="isImpersonating" class="d-flex align-items-center">
                    <div class="badge bg-warning text-dark me-2 px-3 py-2">
                        <i class="fa fa-user-secret me-1"></i>
                        Actuando como otro usuario
                    </div>
                    <button class="btn btn-sm btn-outline-warning" @click="returnToOriginalUser">
                        <i class="fa fa-arrow-left me-1"></i> Volver a mi usuario
                    </button>
                </div>
            </div>

            <div class="app-header-right">
                <div class="header-btn-lg pe-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-bs-toggle="dropdown"
                                       aria-haspopup="true"
                                       aria-expanded="false"
                                       class="p-0 btn">
                                        <img v-if="user && user.image_url"
                                             width="42"
                                             class="rounded-circle"
                                             :src="user.image_url"
                                             alt="">
                                        <img v-else
                                             width="42"
                                             class="rounded-circle"
                                             :src="'/images/default-profile.jpeg'"
                                             alt="">
                                        <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                    </a>

                                    <div tabindex="-1"
                                         role="menu"
                                         aria-hidden="true"
                                         class="rm-pointers dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                        <div class="dropdown-menu-header">
                                            <div class="dropdown-menu-header-inner bg-focus">
                                                <div class="menu-header-content text-start">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left me-3">
                                                                <img v-if="user && user.image_url"
                                                                     width="42"
                                                                     class="rounded-circle"
                                                                     :src="user.image_url"
                                                                     alt="">
                                                                <img v-else
                                                                     width="42"
                                                                     class="rounded-circle"
                                                                     :src="'/images/default-profile.jpeg'"
                                                                     alt="">
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">{{ userName }}</div>
                                                                <div class="widget-subheading opacity-8">{{ companyName }}</div>
                                                            </div>
                                                            <div class="widget-content-right me-2">
                                                                <button class="btn-pill btn-shadow btn-shine btn btn-focus"
                                                                        @click="logout">
                                                                    Salir
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="widget-content-left ms-3 header-user-info">
                                <div class="widget-heading">{{ userName }}</div>
                                <div class="widget-subheading">ROLES: {{ rolesDisplay }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '@/store/auth';

export default {
    name: 'AppHeader',

    computed: {
        user() {
            return auth.user;
        },

        userName() {
            return auth.user ? auth.user.name : '';
        },

        companyName() {
            return auth.user ? auth.user.company_name : '';
        },

        isImpersonating() {
            return auth.isImpersonating;
        },

        rolesDisplay() {
            return auth.roles.map(r => r.toUpperCase()).join(', ');
        },
    },

    methods: {
        async logout() {
            try {
                await window.axios.post('/logout');
            } catch (e) {
                // ignorar error
            }
            auth.clear();
            this.$router.push('/login');
        },

        async returnToOriginalUser() {
            try {
                const response = await window.axios.post('/return-to-original-user');
                auth.clear();
                await auth.load();
                if (response.data.redirect) {
                    this.$router.push(response.data.redirect);
                }
            } catch (e) {
                console.error('Error al volver al usuario original', e);
            }
        },
    },
};
</script>
