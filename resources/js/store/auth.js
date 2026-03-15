import { reactive } from 'vue';

const auth = reactive({
    user: null,
    roles: [],
    permissions: [],
    isImpersonating: false,
    loaded: false,

    async load() {
        try {
            const response = await window.axios.get('/api/me');
            if (response.data.authenticated) {
                this.user = response.data.user;
                this.roles = response.data.roles;
                this.permissions = response.data.permissions;
                this.isImpersonating = response.data.is_impersonating;
            } else {
                this.user = null;
                this.roles = [];
                this.permissions = [];
                this.isImpersonating = false;
            }
        } catch (e) {
            this.user = null;
            this.roles = [];
            this.permissions = [];
            this.isImpersonating = false;
        } finally {
            this.loaded = true;
        }
    },

    can(permissionName) {
        return this.permissions.includes(permissionName);
    },

    hasRole(roleName) {
        return this.roles.map(r => r.toLowerCase()).includes(roleName.toLowerCase());
    },

    clear() {
        this.user = null;
        this.roles = [];
        this.permissions = [];
        this.isImpersonating = false;
        this.loaded = false;
    }
});

export default auth;
