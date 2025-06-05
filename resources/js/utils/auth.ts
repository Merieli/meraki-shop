import { getApiToken } from './cookies';

/**
 * Prepara um objeto de configuração para requisições autenticadas com token
 * Útil para casos onde você precisa usar o token explicitamente ou em bibliotecas terceiras
 */
export const prepareAuthHeaders = () => {
    const token = getApiToken();

    if (!token) {
        console.warn('Token de API não encontrado no cookie');
        return {};
    }

    return {
        Authorization: `Bearer ${token}`,
    };
};
