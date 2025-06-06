<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { type CardApiData, type CardFormData } from '@/types/card';
import { useValidation, z } from '@/utils/formValidation';
import { ref } from 'vue';
import CardBasicInfo from './CardBasicInfo.vue';

const props = defineProps<{
    initialData?: Partial<CardFormData>;
    submitEndpoint: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'submit', data: CardApiData): void;
    (e: 'cancel'): void;
}>();

const cardSchema = z.object({
    card_number: z
        .string()
        .min(13, { message: 'Card number must be at least 13 digits.' })
        .max(19, { message: 'Card number cannot exceed 19 digits.' }),
    cardholder_name: z
        .string()
        .min(2, { message: 'Cardholder name must be at least 2 characters.' })
        .max(100, { message: 'Cardholder name cannot exceed 100 characters.' }),
    expiration_date: z.string().regex(/^(0[1-9]|1[0-2])\/([0-9]{2})$/, { message: 'Expiration date must be in MM/YY format.' }),
    cvv: z.string().min(3, { message: 'CVV must be at least 3 digits.' }).max(4, { message: 'CVV cannot exceed 4 digits.' }),
    card_brand: z
        .string()
        .min(2, { message: 'Card brand must be at least 2 characters.' })
        .max(50, { message: 'Card brand cannot exceed 50 characters.' }),
});

const defaultFormData: CardFormData = {
    card_number: '',
    cardholder_name: '',
    expiration_date: '',
    cvv: '',
    card_brand: '',
};

const formData = ref<CardFormData>({
    ...defaultFormData,
    ...props.initialData,
});

const isSubmitting = ref(false);
const { errors, validateField, validateAll } = useValidation<CardFormData>(cardSchema);

/**
 * Clean the card number before submitting
 * @param cardNumber - The card number to clean
 * @returns The cleaned card number
 */
const cleanCardNumber = (cardNumber: string) => {
    return cardNumber.replace(/\s+|-/g, '');
};

const handleSubmit = async () => {
    const cleanNumber = cleanCardNumber(formData.value.card_number);
    formData.value.card_number = cleanNumber;

    if (!validateAll(formData.value)) {
        return;
    }

    isSubmitting.value = true;

    try {
        const cardToken = generateCardToken(formData.value.card_number);
        const cardLast4 = formData.value.card_number.slice(-4);

        emit('submit', {
            card_number: cardToken,
            card_last4: cardLast4,
            card_brand: formData.value.card_brand,
        });
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

/**
 * Generate a fake card token
 * @param cardNumber - The card number
 * @returns The generated card token
 */
const generateCardToken = (cardNumber: string): string => {
    const bin = cardNumber.substring(0, 6);
    const last4 = cardNumber.slice(-4);
    const timestamp = Date.now().toString().slice(-8);
    return `tok_${bin}_${timestamp}_${last4}`;
};

const sections = [{ id: 'card', title: 'Card Information' }];
</script>

<template>
    <Form @submit.prevent>
        <!-- Form content -->
        <div class="space-y-8">
            <!-- Card Information Section -->
            <div>
                <h3 class="mb-4 text-lg font-medium">{{ sections[0].title }}</h3>
                <div class="rounded-md border p-4">
                    <CardBasicInfo :form-data="formData" :errors="errors" :validate-field="validateField" />
                </div>
            </div>

            <!-- Form actions -->
            <div class="flex justify-end space-x-4 pt-4">
                <Button type="button" variant="outline" @click="emit('cancel')" :disabled="props.disabled">Cancel</Button>
                <Button type="button" @click="handleSubmit" :disabled="isSubmitting || props.disabled">
                    {{ isSubmitting ? 'Saving...' : 'Register Card' }}
                </Button>
            </div>
        </div>
    </Form>
</template>
