<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { useValidation, z } from '@/utils/formValidation';
import { ref } from 'vue';
import CardBasicInfo from './CardBasicInfo.vue';

export interface CardFormData {
    card_number: string;
    cardholder_name: string;
    expiration_date: string;
    cvv: string;
    card_brand: string;
}

interface CardApiData {
    card_number: string;
    cardholder_name: string;
    expiration_date: string;
    cvv: string;
    card_brand: string;
}

const props = defineProps<{
    initialData?: Partial<CardFormData>;
    submitEndpoint: string;
}>();

const emit = defineEmits<{
    (e: 'submit', data: CardApiData): void;
    (e: 'cancel'): void;
}>();

const cardSchema = z.object({
    card_number: z
        .string()
        .min(16, { message: 'Card number must be at least 16 digits.' })
        .max(19, { message: 'Card number cannot exceed 19 digits.' }),
    cardholder_name: z
        .string()
        .min(2, { message: 'Cardholder name must be at least 2 characters.' })
        .max(100, { message: 'Cardholder name cannot exceed 100 characters.' }),
    expiration_date: z
        .string()
        .min(5, { message: 'Expiration date must be in MM/YY format.' })
        .max(5, { message: 'Expiration date must be in MM/YY format.' }),
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

const handleSubmit = async () => {
    if (!validateAll(formData.value)) {
        return;
    }

    isSubmitting.value = true;

    try {
        emit('submit', formData.value);
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

const sections = [{ id: 'card', title: 'Card Information' }];
</script>

<template>
    <Form @submit.prevent="handleSubmit">
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
                <Button type="button" variant="outline" @click="emit('cancel')">Cancel</Button>
                <Button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Saving...' : 'Register Card' }}
                </Button>
            </div>
        </div>
    </Form>
</template>
