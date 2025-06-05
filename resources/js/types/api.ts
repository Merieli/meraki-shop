import { AxiosError } from 'axios';

/**
 * Formato de erro de validação da API
 */
export interface ValidationError {
    [field: string]: string[];
}

/**
 * Formato da resposta de erro da API
 */
export interface ApiErrorResponse {
    message: string;
    errors?: ValidationError;
}

/**
 * Tipo para erro de API com tipagem completa
 */
export type ApiError = AxiosError<ApiErrorResponse>;

/**
 * Verifica se um erro é um erro de API tipado
 */
export function isApiError(error: any): error is ApiError {
    return (
        error &&
        error.isAxiosError &&
        error.response &&
        error.response.data &&
        (typeof error.response.data.message === 'string' || typeof error.response.data.errors === 'object')
    );
}

/**
 * Extrai a primeira mensagem de erro de validação de um erro da API
 */
export function getFirstValidationError(error: ApiError): string | null {
    if (!error.response || !error.response.data.errors) {
        return null;
    }

    const errors = error.response.data.errors;
    const firstField = Object.keys(errors)[0];

    if (!firstField || !errors[firstField] || !errors[firstField].length) {
        return null;
    }

    return errors[firstField][0];
}
