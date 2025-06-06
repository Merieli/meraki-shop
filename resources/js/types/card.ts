/**
 * Dados do cartão para processamento no frontend
 */
export interface CardFormData {
    card_number: string;
    cardholder_name: string;
    expiration_date: string;
    cvv: string;
    card_brand: string;
}

/**
 * Dados do cartão para envio à API (apenas dados seguros)
 */
export interface CardApiData {
    card_number: string;
    card_last4: string;
    card_brand: string;
    cardholder_name?: string;
    expiration_date?: string;
    cvv?: string;
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
