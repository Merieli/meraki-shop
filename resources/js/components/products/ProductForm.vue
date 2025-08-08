<script setup lang="ts">
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { type PartialProductData, type ProductApiData } from '@/types/product';
import { computed } from 'vue';
import ProductBasicInfo from './ProductBasicInfo.vue';
import ProductMedia from './ProductMedia.vue';
import ProductPricing from './ProductPricing.vue';
import { useProductForm } from './useProductForm';

const props = defineProps<{
    initialData?: PartialProductData;
    submitEndpoint: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'submit', data: ProductApiData): void;
    (e: 'cancel'): void;
}>();

const { formData, isSubmitting, error, success, errors, isValid, validateField, validateAll, submitProduct } = useProductForm(props.initialData);

const isButtonDisabled = computed(() => isSubmitting.value || props.disabled || !isValid.value);

const validationSchema = {
    name: (value: string) => {
        if (!value) return 'Nome é obrigatório';
        if (value.length < 4) return 'Nome deve ter pelo menos 4 caracteres';
        if (value.length > 150) return 'Nome não pode exceder 150 caracteres';
        return true;
    },
    price: (value: number) => {
        if (value < 0) return 'Preço não pode ser negativo';
        return true;
    },
    cost_price: (value: number) => {
        if (value < 0) return 'Preço de custo não pode ser negativo';
        return true;
    },
    stock: (value: number) => {
        if (value < 0) return 'Estoque não pode ser negativo';
        return true;
    },
    thumbnail: (value: string) => {
        if (!value) return 'URL da imagem é obrigatória';
        if (value.length < 5) return 'URL da imagem deve ter pelo menos 5 caracteres';
        return true;
    },
    short_description: (value: string) => {
        if (!value) return 'Descrição curta é obrigatória';
        if (value.length < 10) return 'Descrição curta deve ter pelo menos 10 caracteres';
        if (value.length > 255) return 'Descrição curta não pode exceder 255 caracteres';
        return true;
    },
    rating: (value: number) => {
        if (!value && value !== 0) return 'Avaliação é obrigatória';
        if (value < 1) return 'Avaliação deve ser pelo menos 1';
        if (value > 5) return 'Avaliação não pode exceder 5';
        return true;
    },
    sku: (value: string) => {
        if (value && value.length > 50) return 'SKU não pode exceder 50 caracteres';
        return true;
    },
};

const onSubmit = async () => {
    const result = await submitProduct();

    if (result) {
        // Se a requisição foi bem-sucedida, emitir evento para o componente pai
        emit('submit', result);
    }
};

const sections = [
    { id: 'basic', title: 'Basic Information' },
    { id: 'pricing', title: 'Pricing & Inventory' },
    { id: 'media', title: 'Media & Rating' },
];
</script>

<template>
    <Form @submit="onSubmit" :validation-schema="validationSchema" :initial-values="formData">
        <div class="product-form">
            <!-- Error and Success Alerts -->
            <div v-if="error || success" class="mb-6">
                <Alert v-if="error" variant="destructive" class="mb-4">
                    <AlertDescription>{{ error }}</AlertDescription>
                </Alert>
                <Alert v-if="success" class="mb-4 border-green-200 bg-green-50 text-green-800">
                    <AlertDescription>{{ success }}</AlertDescription>
                </Alert>
            </div>

            <!-- Form content -->
            <div class="space-y-8">
                <!-- Basic Information Section -->
                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[0].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductBasicInfo
                            v-model:name="formData.name"
                            v-model:description="formData.description"
                            v-model:short_description="formData.short_description"
                            :errors="errors"
                            :validate-field="validateField"
                        />
                    </div>
                </div>

                <!-- Pricing & Inventory Section -->
                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[1].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductPricing
                            v-model:price="formData.price"
                            v-model:cost="formData.cost_price"
                            v-model:stock="formData.stock"
                            v-model:sku="formData.sku"
                            :errors="errors"
                            :validate-field="validateField"
                        />
                    </div>
                </div>

                <!-- Media & Rating Section -->
                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[2].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductMedia
                            v-model:thumbnail="formData.thumbnail"
                            v-model:images="formData.images"
                            v-model:rating="formData.rating"
                            :errors="errors"
                            :validate-field="validateField"
                        />
                    </div>
                </div>

                <!-- Form actions -->
                <div class="flex justify-end space-x-4 pt-4">
                    <Button type="button" variant="outline" @click="emit('cancel')" :disabled="isSubmitting">Cancel</Button>
                    <Button
                        type="submit"
                        :disabled="isButtonDisabled"
                        :class="{
                            'cursor-not-allowed opacity-75': isButtonDisabled,
                            'bg-green-600 hover:bg-green-700': !isButtonDisabled,
                        }"
                    >
                        <div class="flex items-center space-x-2">
                            <div v-if="isSubmitting" class="h-4 w-4 animate-spin rounded-full border-b-2 border-white"></div>
                            <span>{{ isSubmitting ? 'Criando Produto...' : 'Create Product' }}</span>
                        </div>
                    </Button>
                </div>
            </div>
        </div>
    </Form>
</template>
