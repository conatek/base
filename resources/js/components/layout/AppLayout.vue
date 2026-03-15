<template>
    <div class="app-container app-theme-green body-tabs-shadow fixed-header fixed-sidebar">
        <app-header></app-header>

        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
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

                <app-sidebar></app-sidebar>
            </div>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <router-view></router-view>
                </div>
                <app-footer></app-footer>
            </div>
        </div>
    </div>
</template>

<script>
import AppHeader from './AppHeader.vue';
import AppSidebar from './AppSidebar.vue';
import AppFooter from './AppFooter.vue';

export default {
    name: 'AppLayout',

    components: {
        AppHeader,
        AppSidebar,
        AppFooter,
    },
};
</script>
