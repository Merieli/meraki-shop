/**
 * Utilitário para gerenciar cookies no frontend
 */

/**
 * Obtém o valor de um cookie específico
 * @param name Nome do cookie
 * @returns O valor do cookie ou null se não encontrado
 */
export function getCookie(name: string): string | null {
    const match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
    return match ? decodeURIComponent(match[3]) : null;
}

/**
 * Obtém o token de API armazenado no cookie X-API-TOKEN
 * @returns O token de API ou null se não estiver disponível
 */
export function getApiToken(): string | null {
    return getCookie('X-API-TOKEN');
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
