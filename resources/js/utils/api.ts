import axios from 'axios';
import { getApiToken } from './cookies';

// Endpoints protegidos que precisam de token
const protectedEndpoints = ['/users', '/address', '/credit-card', '/token'];

const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
});

api.interceptors.request.use((config) => {
    const token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        config.headers['X-CSRF-TOKEN'] = (token as HTMLMetaElement).content;
    }

    const url = config.url ? (config.url.startsWith('/') ? config.url : `/${config.url}`) : '';

    const isProtectedEndpoint = protectedEndpoints.some((endpoint) => url === endpoint || url.startsWith(`${endpoint}/`));

    const useToken = config.useToken === true || isProtectedEndpoint;
    console.log('useToken', useToken);
    if (useToken) {
        const apiToken = getApiToken();
        console.log('apiToken', apiToken);
        if (apiToken) {
            config.headers['Authorization'] = `Bearer ${apiToken}`;
        }
    }

    return config;
});

declare module 'axios' {
    interface AxiosRequestConfig {
        useToken?: boolean;
        skipToken?: boolean;
    }
}

export const apiService = {
    /**
     * Verifica se o usuário está autenticado
     */
    async checkAuth(): Promise<boolean> {
        try {
            const response = await api.get('/user', { useToken: true });
            return !!response.data;
        } catch (error) {
            return false;
        }
    },

    /**
     * Envia uma requisição POST para criar um recurso
     * @param useToken Se true, força o uso do token de autenticação
     */
    async create<T>(endpoint: string, data: any, useToken = false): Promise<T> {
        try {
            const response = await api.post(endpoint, data, { useToken });
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição GET para obter uma lista de recursos
     * @param useToken Se true, força o uso do token de autenticação
     */
    async list<T>(endpoint: string, params = {}, useToken = false): Promise<T> {
        try {
            const response = await api.get(endpoint, { params, useToken });
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição GET para obter um único recurso
     * @param useToken Se true, força o uso do token de autenticação
     */
    async get<T>(endpoint: string, id: string | number, useToken = false): Promise<T> {
        try {
            const response = await api.get(`${endpoint}/${id}`, { useToken });
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição PUT para atualizar um recurso
     * @param useToken Se true, força o uso do token de autenticação
     */
    async update<T>(endpoint: string, id: string | number, data: any, useToken = false): Promise<T> {
        try {
            const response = await api.put(`${endpoint}/${id}`, data, { useToken });
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição DELETE para remover um recurso
     * @param useToken Se true, força o uso do token de autenticação
     */
    async delete(endpoint: string, id: string | number, useToken = false): Promise<void> {
        try {
            await api.delete(`${endpoint}/${id}`, { useToken });
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },
};

export default api;
