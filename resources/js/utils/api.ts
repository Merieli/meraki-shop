import axios from 'axios';

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

    return config;
});

export const apiService = {
    /**
     * Envia uma requisição POST para criar um recurso
     */
    async create<T>(endpoint: string, data: any): Promise<T> {
        try {
            const response = await api.post(endpoint, data);
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição GET para obter uma lista de recursos
     */
    async list<T>(endpoint: string, params = {}): Promise<T> {
        try {
            const response = await api.get(endpoint, { params });
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição GET para obter um único recurso
     */
    async get<T>(endpoint: string, id: string | number): Promise<T> {
        try {
            const response = await api.get(`${endpoint}/${id}`);
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição PUT para atualizar um recurso
     */
    async update<T>(endpoint: string, id: string | number, data: any): Promise<T> {
        try {
            const response = await api.put(`${endpoint}/${id}`, data);
            return response.data;
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },

    /**
     * Envia uma requisição DELETE para remover um recurso
     */
    async delete(endpoint: string, id: string | number): Promise<void> {
        try {
            await api.delete(`${endpoint}/${id}`);
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },
};

export default api;
