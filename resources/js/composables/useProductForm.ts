import { type PartialProductData } from '@/types/product';
import { apiService } from '@/utils/api';
import { computed, ref } from 'vue';
import { convertToApiFormat, defaultFormData, filterFilledFields } from '../features/products/product-form-helpers';

export function useProductForm(initialData?: PartialProductData) {
    const formData = ref({
        ...defaultFormData,
        ...initialData,
    });

    const isSubmitting = ref(false);
    const error = ref<string | null>(null);
    const success = ref<string | null>(null);

    const resetForm = () => {
        formData.value = { ...defaultFormData, ...initialData };
        error.value = null;
        success.value = null;
    };

    const submitProduct = async (): Promise<any> => {
        error.value = null;
        success.value = null;
        isSubmitting.value = true;

        try {
            const apiData = convertToApiFormat(formData.value);
            const filteredData = filterFilledFields(apiData);

            const response = await apiService.create('products', filteredData, true);

            success.value = 'Produto criado com sucesso!';
            return response;
        } catch (err: any) {
            console.error('Erro ao criar produto:', err);

            if (err?.response?.status === 422) {
                error.value = 'Dados inválidos. Verifique os campos preenchidos.';
            } else if (err?.response?.status === 401) {
                error.value = 'Você precisa estar logado para criar produtos.';
            } else if (err?.response?.status === 403) {
                error.value = 'Você não tem permissão para criar produtos.';
            } else {
                error.value = 'Erro interno do servidor. Tente novamente mais tarde.';
            }

            return false;
        } finally {
            isSubmitting.value = false;
        }
    };

    return {
        formData,
        isSubmitting,
        error,
        success,
        resetForm,
        submitProduct,
    };
}
