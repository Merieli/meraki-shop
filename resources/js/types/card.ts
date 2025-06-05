/**
 * Dados do cartão para processamento no frontend
 */
export interface CardFormData {
    card_number: string; // Número completo do cartão (apenas para frontend)
    cardholder_name: string; // Nome do titular (apenas para frontend)
    expiration_date: string; // Data de validade (apenas para frontend)
    cvv: string; // CVV (apenas para frontend, nunca armazenado)
    card_brand: string; // Bandeira do cartão
}

/**
 * Dados do cartão para envio à API (apenas dados seguros)
 */
export interface CardApiData {
    card_number: string; // Token do cartão (gerado a partir do número real)
    card_last4: string; // Últimos 4 dígitos do cartão
    card_brand: string; // Bandeira do cartão

    // Estes campos são usados apenas no formulário e não são enviados ao backend
    cardholder_name?: string; // Nome do titular (não enviado ao backend)
    expiration_date?: string; // Data de validade (não enviado ao backend)
    cvv?: string; // CVV (não enviado ao backend)
}

/**
 * Resposta da API ao criar ou obter um cartão
 */
export interface CardResponse {
    id: number;
    card_token: string;
    card_last4: string;
    card_brand: string;
    created_at: string;
    updated_at: string;
}

/**
 * Lista de possíveis bandeiras de cartão
 */
export const cardBrands = [
    { value: 'Visa', label: 'Visa' },
    { value: 'Mastercard', label: 'Mastercard' },
    { value: 'American Express', label: 'American Express' },
    { value: 'Discover', label: 'Discover' },
    { value: 'Elo', label: 'Elo' },
    { value: 'Hipercard', label: 'Hipercard' },
    { value: 'Diners Club', label: 'Diners Club' },
    { value: 'JCB', label: 'JCB' },
    { value: 'Other', label: 'Other' },
];
