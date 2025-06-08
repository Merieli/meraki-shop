import axios from 'axios';
import { ref } from 'vue';

export interface AddressApiData {
    label: string;
    recipient_name: string;
    street: string;
    number: string;
    neighborhood: string;
    complement: string;
    city: string;
    state: string;
    country: string;
    postal_code: string;
}

export function useAddressPage() {
    const isSubmitting = ref(false);
    const error = ref<string | null>(null);
    const success = ref<string | null>(null);
    const formKey = ref(0);

    const createAddress = async (addressData: AddressApiData) => {
        isSubmitting.value = true;
        error.value = null;
        success.value = null;

        try {
            await axios.post('/api/address', addressData);
            success.value = 'Endereço cadastrado com sucesso!';
            formKey.value++;
        } catch (err: any) {
            console.error('Error creating address:', err);
            error.value = err.response?.data?.message || 'Ocorreu um erro ao cadastrar o endereço.';
        } finally {
            isSubmitting.value = false;
        }
    };

    return {
        isSubmitting,
        error,
        success,
        formKey,
        createAddress,
    };
}
