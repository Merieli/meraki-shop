import { apiService } from '@/utils/api';
import { deleteCookie } from '@/utils/cookies';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

export function useAuth() {
    const isAuthenticated = ref<boolean | null>(null);
    const isLoading = ref(false);
    const authError = ref<string | null>(null);

    const isAuthChecked = computed(() => isAuthenticated.value !== null);

    const checkAuthentication = async () => {
        if (isLoading.value) return;

        isLoading.value = true;
        authError.value = null;

        try {
            isAuthenticated.value = await apiService.checkAuth();
            return isAuthenticated.value;
        } catch (error) {
            console.error('Erro ao verificar autenticação:', error);
            authError.value = 'Erro ao verificar status de autenticação';
            isAuthenticated.value = false;
            return false;
        } finally {
            isLoading.value = false;
        }
    };

    const redirectToLogin = () => {
        router.visit('/login');
    };

    const requireAuth = async () => {
        const isAuth = await checkAuthentication();

        if (!isAuth) {
            redirectToLogin();
            return false;
        }

        return true;
    };

    const logout = () => {
        deleteCookie('X-API-TOKEN');
        window.location.href = '/logout';
    };

    return {
        isAuthenticated,
        isLoading,
        authError,
        isAuthChecked,
        checkAuthentication,
        requireAuth,
        redirectToLogin,
        logout,
    };
}
