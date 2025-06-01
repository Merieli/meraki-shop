<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { useValidation, z } from '@/utils/formValidation';
import { toCents } from '@/utils/money';
import { ref } from 'vue';
import ProductBasicInfo from './ProductBasicInfo.vue';
import ProductMedia from './ProductMedia.vue';
import ProductPricing from './ProductPricing.vue';

export interface ProductFormData {
    name: string;
    price: number;
    cost_price: number;
    stock: number;
    thumbnail: string;
    images: string;
    short_description: string;
    description: string;
    rating: number;
    sku: string;
}

interface ProductApiData {
    name: string;
    price: number; // In cents (integer)
    cost_price: number; // In cents (integer)
    stock: number;
    thumbnail: string;
    images: string;
    short_description: string;
    description: string;
    rating: number;
    sku: string;
}

const props = defineProps<{
    initialData?: Partial<ProductFormData>;
    submitEndpoint: string;
}>();

const emit = defineEmits<{
    (e: 'submit', data: ProductApiData): void;
    (e: 'cancel'): void;
}>();

const productSchema = z.object({
    name: z.string().min(2, { message: 'Name must be at least 2 characters.' }).max(150, { message: 'Name cannot exceed 150 characters.' }),
    price: z.number().min(0, { message: 'Price cannot be negative.' }),
    cost_price: z.number().min(0, { message: 'Cost price cannot be negative.' }),
    stock: z.number().min(0, { message: 'Stock cannot be negative.' }),
    thumbnail: z.string().min(1, { message: 'Thumbnail is required.' }),
    images: z.string(),
    short_description: z
        .string()
        .min(10, { message: 'Short description must be at least 10 characters.' })
        .max(255, { message: 'Short description cannot exceed 255 characters.' }),
    description: z.string(),
    rating: z.number().min(0, { message: 'Rating cannot be negative.' }).max(5, { message: 'Rating cannot exceed 5.' }),
    sku: z.string().max(50, { message: 'SKU cannot exceed 50 characters.' }),
    status: z.enum(['draft', 'published']),
});

const defaultFormData: ProductFormData = {
    name: '',
    price: 0,
    cost_price: 0,
    stock: 0,
    thumbnail: '',
    images: '',
    short_description: '',
    description: '',
    rating: 0,
    sku: '',
};

const formData = ref<ProductFormData>({
    ...defaultFormData,
    ...props.initialData,
});

const isSubmitting = ref(false);
const { errors, validateField, validateAll } = useValidation<ProductFormData>(productSchema);

/**
 * Converts form data values with decimal prices to API data with integer cents
 */
const convertToApiFormat = (data: ProductFormData): ProductApiData => {
    return {
        ...data,
        price: toCents(data.price),
        cost_price: toCents(data.cost_price),
    };
};

const handleSubmit = async () => {
    if (!validateAll(formData.value)) {
        return;
    }

    isSubmitting.value = true;

    try {
        const apiData = convertToApiFormat(formData.value);
        emit('submit', apiData);
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

const sections = [
    { id: 'basic', title: 'Basic Information' },
    { id: 'pricing', title: 'Pricing & Inventory' },
    { id: 'media', title: 'Media & Rating' },
];
</script>

<template>
    <Form @submit.prevent="handleSubmit">
        <!-- Form content -->
        <div class="space-y-8">
            <!-- Basic Information Section -->
            <div>
                <h3 class="mb-4 text-lg font-medium">{{ sections[0].title }}</h3>
                <div class="rounded-md border p-4">
                    <ProductBasicInfo :form-data="formData" :errors="errors" :validate-field="validateField" />
                </div>
            </div>

            <!-- Pricing & Inventory Section -->
            <div>
                <h3 class="mb-4 text-lg font-medium">{{ sections[1].title }}</h3>
                <div class="rounded-md border p-4">
                    <ProductPricing :form-data="formData" :errors="errors" :validate-field="validateField" />
                </div>
            </div>

            <!-- Media & Rating Section -->
            <div>
                <h3 class="mb-4 text-lg font-medium">{{ sections[2].title }}</h3>
                <div class="rounded-md border p-4">
                    <ProductMedia :form-data="formData" :errors="errors" :validate-field="validateField" />
                </div>
            </div>

            <!-- Form actions -->
            <div class="flex justify-end space-x-4 pt-4">
                <Button type="button" variant="outline" @click="emit('cancel')">Cancel</Button>
                <Button type="submit" :disabled="isSubmitting">
                    {{ isSubmitting ? 'Saving...' : 'Create Product' }}
                </Button>
            </div>
        </div>
    </Form>
</template>
