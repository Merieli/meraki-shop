<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { useValidation, z } from '@/utils/formValidation';
import { toCents } from '@/utils/money';
import { computed, ref } from 'vue';
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
    cost_price: number | null; // In cents (integer), optional
    stock: number | null; // optional
    thumbnail: string;
    images: string | null; // optional
    short_description: string;
    description: string | null; // optional
    rating: number;
    sku: string | null; // optional
}

const props = defineProps<{
    initialData?: Partial<ProductFormData>;
    submitEndpoint: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'submit', data: ProductApiData): void;
    (e: 'cancel'): void;
}>();

const productSchema = z.object({
    name: z.string().min(4, { message: 'Nome deve ter pelo menos 4 caracteres.' }).max(150, { message: 'Nome não pode exceder 150 caracteres.' }),
    price: z.number().min(0, { message: 'Preço não pode ser negativo.' }),
    cost_price: z.number().min(0, { message: 'Preço de custo não pode ser negativo.' }),
    stock: z.number().min(0, { message: 'Estoque não pode ser negativo.' }),
    thumbnail: z.string().min(5, { message: 'URL da imagem é obrigatória e deve ter pelo menos 5 caracteres.' }),
    images: z.string(),
    short_description: z
        .string()
        .min(10, { message: 'Descrição curta deve ter pelo menos 10 caracteres.' })
        .max(255, { message: 'Descrição curta não pode exceder 255 caracteres.' }),
    description: z.string(),
    rating: z.number().min(1, { message: 'Avaliação deve ser pelo menos 1.' }).max(5, { message: 'Avaliação não pode exceder 5.' }),
    sku: z.string().max(50, { message: 'SKU não pode exceder 50 caracteres.' }),
});

const defaultFormData: ProductFormData = {
    name: '',
    price: 0,
    cost_price: 0,
    stock: 0,
    thumbnail: 'https://placeholder.com/300x200',
    images: '',
    short_description: '',
    description: '',
    rating: 1,
    sku: '',
};

const formData = ref<ProductFormData>({
    ...defaultFormData,
    ...props.initialData,
});

const isSubmitting = ref(false);
const { errors, validateField, validateAll } = useValidation<ProductFormData>(productSchema);

// Computed property para controlar quando o botão deve estar desabilitado
const isButtonDisabled = computed(() => isSubmitting.value || props.disabled);

/**
 * Converts form data values to the format expected by the API
 */
const convertToApiFormat = (data: ProductFormData): ProductApiData => {
    // Ensure all numeric fields are integers
    const price = toCents(data.price);

    // Tratar campos opcionais
    const costPrice = data.cost_price ? toCents(data.cost_price) : null;
    const stock = data.stock ? Math.round(data.stock) : null;
    const rating = Math.round(data.rating || 1);

    // Ensure rating is at least 1
    const validRating = rating < 1 ? 1 : rating > 5 ? 5 : rating;

    // Ensure strings are properly formatted
    const name = data.name.trim();
    const thumbnail = data.thumbnail.trim();
    const shortDescription = data.short_description.trim();

    // Format optional string fields
    const description = data.description?.trim() || null;
    const images = data.images?.trim() || null;
    const sku = data.sku?.trim() || null;

    return {
        name,
        price,
        cost_price: costPrice,
        stock,
        thumbnail,
        images,
        short_description: shortDescription,
        description,
        rating: validRating,
        sku,
    };
};

const submitForm = async () => {
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
    <div class="product-form">
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
                <Button type="button" variant="outline" @click="emit('cancel')" :disabled="isButtonDisabled">Cancel</Button>
                <Button type="button" @click="submitForm" :disabled="isButtonDisabled">
                    {{ isSubmitting ? 'Saving...' : 'Create Product' }}
                </Button>
            </div>
        </div>
    </div>
</template>
