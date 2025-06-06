import { getFirstValidationError, isApiError } from '@/types/api';
import { CardApiData, CardResponse } from '@/types/card';
import { apiService } from '@/utils/api';
import { ref } from 'vue';

export type { CardApiData, CardResponse };

export function useCardPage() {
    const isSubmitting = ref(false);
    const error = ref<string | null>(null);
    const success = ref<string | null>(null);
    const formKey = ref(0);

    const resetForm = () => {
        formKey.value++;
    };

    const clearMessages = () => {
        error.value = null;
        success.value = null;
    };

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    const setErrorMessage = (message: string) => {
        error.value = message;
        scrollToTop();
    };

    const setSuccessMessage = (message: string) => {
        success.value = message;
        scrollToTop();
    };

    const validateCard = (card: CardApiData): boolean => {
        if (card.card_number.startsWith('tok_') && card.card_last4) {
            return true;
        }

        if (!card.card_last4) {
            setErrorMessage('Dados do cartão inválidos');
            return false;
        }

        if (!card.expiration_date) {
            setErrorMessage('Data de expiração inválida');
            return false;
        }

        if (!card.card_brand) {
            setErrorMessage('Bandeira do cartão é obrigatória');
            return false;
        }

        return true;
    };

    const handleApiValidationError = (err: Parameters<typeof isApiError>[0]) => {
        if (!isApiError(err)) {
            return false;
        }

        const validationError = getFirstValidationError(err);
        if (!validationError) {
            return false;
        }

        setErrorMessage(`Falha ao cadastrar cartão: ${validationError}`);
        return true;
    };

    const handleApiMessageError = (err: Parameters<typeof isApiError>[0]) => {
        if (!isApiError(err)) {
            return false;
        }

        if (!err.response?.data?.message) {
            return false;
        }

        setErrorMessage(`Falha ao cadastrar cartão: ${err.response.data.message}`);
        return true;
    };

    const handleApiError = (err: unknown) => {
        console.error('Erro na requisição:', err);

        if (handleApiValidationError(err)) return;

        if (handleApiMessageError(err)) return;

        const defaultMessage = isApiError(err)
            ? 'Falha ao cadastrar cartão. Verifique os dados e tente novamente.'
            : 'Ocorreu um erro ao processar sua solicitação. Tente novamente.';

        setErrorMessage(defaultMessage);
    };

    const handleCardCreationSuccess = (response: CardResponse) => {
        setSuccessMessage(`Cartão cadastrado com sucesso! Os últimos 4 dígitos (${response.card_last4}) foram salvos para referência futura.`);
        resetForm();
    };

    const performCardCreation = async (formData: CardApiData): Promise<CardResponse | null> => {
        try {
            const apiData = {
                card_token: formData.card_number,
                card_last4: formData.card_last4,
                card_brand: formData.card_brand,
            };

            console.log('Enviando para API:', apiData);

            return await apiService.create<CardResponse>('credit-card', apiData, true);
        } catch (err: unknown) {
            handleApiError(err);
            return null;
        }
    };

    const createCard = async (formData: CardApiData): Promise<CardResponse | null> => {
        clearMessages();
        isSubmitting.value = true;

        try {
            if (!validateCard(formData)) {
                isSubmitting.value = false;
                return null;
            }

            const response = await performCardCreation(formData);

            if (!response) {
                return null;
            }

            handleCardCreationSuccess(response);
            return response;
        } finally {
            isSubmitting.value = false;
        }
    };

    return {
        isSubmitting,
        error,
        success,
        formKey,
        resetForm,
        clearMessages,
        handleApiError,
        createCard,
    };
}
