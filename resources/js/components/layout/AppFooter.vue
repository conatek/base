<template>
    <div class="app-wrapper-footer">
        <div class="app-footer">
            <div class="app-footer__inner">
                <div class="app-footer-right">
                    <ul class="header-megamenu nav">
                        <li class="nav-item">
                            Todos los derechos reservados &copy; Muy Humano {{ currentYear }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AppFooter',

    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
};
</script>
