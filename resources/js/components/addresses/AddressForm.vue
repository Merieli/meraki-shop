<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { useValidation, z } from '@/utils/formValidation';
import { ref } from 'vue';
import AddressBasicInfo from './AddressBasicInfo.vue';

export interface AddressFormData {
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

interface AddressApiData {
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

const props = defineProps<{
    initialData?: Partial<AddressFormData>;
    submitEndpoint: string;
}>();

const emit = defineEmits<{
    (e: 'submit', data: AddressApiData): void;
    (e: 'cancel'): void;
}>();

const addressSchema = z.object({
    label: z.string().min(2, { message: 'Label must be at least 2 characters.' }).max(20, { message: 'Label cannot exceed 20 characters.' }),
    recipient_name: z
        .string()
        .min(2, { message: 'Recipient name must be at least 2 characters.' })
        .max(100, { message: 'Recipient name cannot exceed 100 characters.' }),
    street: z.string().min(2, { message: 'Street must be at least 2 characters.' }).max(150, { message: 'Street cannot exceed 150 characters.' }),
    number: z.string().max(20, { message: 'Number cannot exceed 20 characters.' }),
    neighborhood: z
        .string()
        .min(2, { message: 'Neighborhood must be at least 2 characters.' })
        .max(80, { message: 'Neighborhood cannot exceed 80 characters.' }),
    complement: z.string().max(50, { message: 'Complement cannot exceed 50 characters.' }),
    city: z.string().min(2, { message: 'City must be at least 2 characters.' }).max(80, { message: 'City cannot exceed 80 characters.' }),
    state: z.string().min(2, { message: 'State must be at least 2 characters.' }).max(50, { message: 'State cannot exceed 50 characters.' }),
    country: z.string().min(2, { message: 'Country must be at least 2 characters.' }).max(80, { message: 'Country cannot exceed 80 characters.' }),
    postal_code: z
        .string()
        .min(2, { message: 'Postal code must be at least 2 characters.' })
        .max(20, { message: 'Postal code cannot exceed 20 characters.' }),
});

const defaultFormData: AddressFormData = {
    label: '',
    recipient_name: '',
    street: '',
    number: '',
    neighborhood: '',
    complement: '',
    city: '',
    state: '',
    country: '',
    postal_code: '',
};

const formData = ref<AddressFormData>({
    ...defaultFormData,
    ...props.initialData,
});

const isSubmitting = ref(false);
const { errors, validateField, validateAll } = useValidation<AddressFormData>(addressSchema);

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

const sections = [{ id: 'address', title: 'Address Information' }];
</script>

<template>
    <Form @submit.prevent="handleSubmit">
        <!-- Form content -->
        <div class="space-y-8">
            <!-- Address Information Section -->
            <div>
                <h3 class="mb-4 text-lg font-medium">{{ sections[0].title }}</h3>
                <div class="rounded-md border p-4">
                    <AddressBasicInfo :form-data="formData" :errors="errors" :validate-field="validateField" />
                </div>
            </div>

            <!-- Form actions -->
            <div class="flex justify-end space-x-4 pt-4">
                <Button type="button" variant="outline" @click="emit('cancel')">Cancel</Button>
                <Button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Saving...' : 'Register Address' }}
                </Button>
            </div>
        </div>
    </Form>
</template>
