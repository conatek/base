import { createRouter, createWebHistory } from 'vue-router';
import auth from '@/store/auth';
import AppLayout from '@/components/layout/AppLayout.vue';

const routes = [
    // ─── Rutas públicas (sin layout autenticado) ───────────────────────────
    {
        path: '/',
        component: () => import('@/pages/WelcomePage.vue'),
    },
    {
        path: '/login',
        component: () => import('@/pages/auth/LoginPage.vue'),
        meta: { requiresGuest: true },
    },
    {
        path: '/password/reset',
        component: () => import('@/pages/auth/ForgotPasswordPage.vue'),
        meta: { requiresGuest: true },
    },
    {
        path: '/password/reset/:token',
        component: () => import('@/pages/auth/ResetPasswordPage.vue'),
        meta: { requiresGuest: true },
    },

    // ─── Rutas autenticadas (con AppLayout) ─────────────────────────────────
    {
        path: '/',
        component: AppLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'home',
                component: () => import('@/components/home/Home.vue'),
                props: () => ({
                    user: auth.user,
                    company_id: auth.user?.company_id,
                    roles: auth.roles,
                }),
            },

            // Empresas (CompanyIndex maneja Create/Show/Edit internamente)
            {
                path: 'companies',
                component: () => import('@/components/company/CompanyIndex.vue'),
            },
            {
                path: 'company',
                component: () => import('@/components/company/CompanyShow.vue'),
                props: () => ({ company_id: auth.user?.company_id }),
            },

            // Usuarios
            {
                path: 'users',
                component: () => import('@/components/users/UserIndex.vue'),
                props: () => ({
                    company_id: auth.user?.company_id,
                    current_user_id: auth.user?.id,
                    current_user_roles: auth.roles,
                }),
            },

            // Roles y Permisos (AccessManager contiene las 3 pestañas)
            {
                path: 'roles',
                component: () => import('@/components/access/AccessManager.vue'),
            },
            {
                path: 'permissions',
                component: () => import('@/components/access/AccessManager.vue'),
            },

            // Colaboradores (CollaboratorIndex maneja Create/Show/Edit internamente)
            {
                path: 'collaborators',
                component: () => import('@/components/collaborators/CollaboratorIndex.vue'),
                props: () => ({ company_id: auth.user?.company_id }),
            },

            // Proveedores
            {
                path: 'staff-providers',
                component: () => import('@/components/staff_providers/StaffProviderIndex.vue'),
                props: () => ({ company_id: auth.user?.company_id }),
            },

            // Módulos
            {
                path: 'modules/selection',
                component: () => import('@/components/modules/selection/Selection.vue'),
            },
            {
                path: 'modules/absence',
                component: () => import('@/components/modules/Absence.vue'),
            },
            {
                path: 'modules/training',
                component: () => import('@/components/modules/Training.vue'),
            },
            {
                path: 'modules/performance',
                component: () => import('@/components/modules/Performance.vue'),
            },
            {
                path: 'modules/provision',
                component: () => import('@/components/modules/Provision.vue'),
            },
            {
                path: 'modules/wellness',
                component: () => import('@/components/modules/Wellness.vue'),
            },

            // Herramientas
            {
                path: 'tools/overtime',
                component: () => import('@/components/tools/Overtime.vue'),
            },
            {
                path: 'tools/inventory',
                component: () => import('@/components/tools/Inventory.vue'),
            },
            {
                path: 'tools/cards',
                component: () => import('@/components/tools/Cards.vue'),
            },

            // Autogestión
            {
                path: 'self-management/profile',
                component: () => import('@/components/users/UserProfile.vue'),
                props: () => ({
                    user: auth.user,
                    roles: auth.roles,
                }),
            },
        ],
    },

    // ─── Catch-all ──────────────────────────────────────────────────────────
    {
        path: '/:pathMatch(.*)*',
        redirect: '/',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) return savedPosition;
        return { top: 0 };
    },
});

router.beforeEach(async (to, from, next) => {
    if (!auth.loaded) {
        await auth.load();
    }

    if (to.meta.requiresAuth && !auth.user) {
        return next({ path: '/login', query: { redirect: to.fullPath } });
    }

    if (to.meta.requiresGuest && auth.user) {
        return next('/home');
    }

    next();
});

export default router;
