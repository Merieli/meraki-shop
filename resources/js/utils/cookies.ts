/**
 * Obtém o valor de um cookie específico
 * @param name Nome do cookie
 * @returns O valor do cookie ou null se não encontrado
 */
export function getCookie(name: string): string | null {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        // Verifica se o cookie começa com o nome buscado seguido por '='
        if (cookie.indexOf(name + '=') === 0) {
            return decodeURIComponent(cookie.substring(name.length + 1));
        }
    }
    return null;
}

/**
 * Obtém o token de API para autenticação
 * @returns O token para autenticação ou null se não estiver disponível
 */
export function getApiToken(): string | null {
    const apiToken = getCookie('X-API-TOKEN');
    if (apiToken) {
        return apiToken;
    }

    return null;
}

/**
 * Define um novo cookie
 * @param name Nome do cookie
 * @param value Valor do cookie
 * @param expiryDays Dias até expirar (opcional)
 */
export function setCookie(name: string, value: string, expiryDays?: number): void {
    let cookieString = `${name}=${encodeURIComponent(value)}`;

    if (expiryDays) {
        const date = new Date();
        date.setTime(date.getTime() + expiryDays * 24 * 60 * 60 * 1000);
        cookieString += `; expires=${date.toUTCString()}`;
    }

    cookieString += '; path=/';
    document.cookie = cookieString;
}

/**
 * Remove um cookie específico
 * @param name Nome do cookie a ser removido
 */
export function deleteCookie(name: string): void {
    setCookie(name, '', -1);
}
