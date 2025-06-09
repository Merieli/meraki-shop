import { ref } from 'vue';

const apiToken = ref<string | null>(null);

export function useApiToken() {
    const token = localStorage.getItem('apiToken');
    if (token && !apiToken.value) {
        apiToken.value = token;
    }
    return { apiToken };
}

export function setApiToken(token: string | null) {
    apiToken.value = token;
    localStorage.setItem('apiToken', token ?? '');
}
