import { getFirstValidationError, isApiError } from '@/types/api';
import { type ProductApiData, type ProductResponse } from '@/types/product';
import { apiService } from '@/utils/api';
import { ref } from 'vue';

export function useProductPage() {
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

    const handleApiValidationError = (err: Parameters<typeof isApiError>[0]) => {
        if (!isApiError(err)) {
            return false;
        }

        const validationError = getFirstValidationError(err);
        if (!validationError) {
            return false;
        }

        setErrorMessage(`Falha ao criar o produto: ${validationError}`);
        return true;
    };

    const handleApiMessageError = (err: Parameters<typeof isApiError>[0]) => {
        if (!isApiError(err)) {
            return false;
        }

        if (!err.response?.data?.message) {
            return false;
        }

        setErrorMessage(`Falha ao criar o produto: ${err.response.data.message}`);
        return true;
    };

    const handleApiError = (err: unknown) => {
        console.error('Erro na requisição:', err);

        if (handleApiValidationError(err)) return;

        if (handleApiMessageError(err)) return;

        const defaultMessage = isApiError(err)
            ? 'Falha ao criar o produto. Verifique os dados e tente novamente.'
            : 'Ocorreu um erro ao processar sua solicitação. Tente novamente.';

        setErrorMessage(defaultMessage);
    };

    const handleProductCreationSuccess = (response: ProductResponse) => {
        console.info('Response: ', response);
        setSuccessMessage('Produto criado com sucesso! Você pode criar outro produto se desejar.');
        resetForm();
    };

    const performProductCreation = async (formData: ProductApiData): Promise<ProductResponse | null> => {
        try {
            return await apiService.create<ProductResponse>('products', formData);
        } catch (err: unknown) {
            handleApiError(err);
            return null;
        }
    };

    const createProduct = async (formData: ProductApiData): Promise<ProductResponse | null> => {
        clearMessages();
        isSubmitting.value = true;

        try {
            const response = await performProductCreation(formData);

            if (!response) {
                return null;
            }

            handleProductCreationSuccess(response);
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
        createProduct,
    };
}
