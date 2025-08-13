<script setup lang="ts">
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Form } from '@/components/ui/form';
import { useProductForm } from '@/composables/useProductForm';
import { productSchema } from '@/features/products/product-form-helpers';
import { type PartialProductData, type ProductApiData } from '@/types/product';
import { computed } from 'vue';
import ProductBasicInfo from './ProductBasicInfo.vue';
import ProductMedia from './ProductMedia.vue';
import ProductPricing from './ProductPricing.vue';

const props = defineProps<{
    initialData?: PartialProductData;
    submitEndpoint: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'submit', data: ProductApiData): void;
    (e: 'cancel'): void;
}>();

const { formData, isSubmitting, error, success, submitProduct } = useProductForm(props.initialData);

const isButtonDisabled = computed(() => isSubmitting.value || props.disabled);

// The `validationSchema` is a computed property that transforms the custom Zod-like schema
// into a format that `vee-validate` can understand. `vee-validate`'s `validation-schema` prop
// can accept an object where keys are field names and values are validation functions.
// This transformation ensures that the validation logic remains centralized in the
// `product-form-helpers.ts` file, and the component just adapts it for `vee-validate`.
const validationSchema = computed(() =>
    Object.fromEntries(
        Object.entries(productSchema.schema).map(([key, field]) => [
            key,
            (value: any) => {
                const result = field.validate(value);
                return result.valid ? true : result.message || 'Invalid field';
            },
        ]),
    ),
);

const onSubmit = async () => {
    const result = await submitProduct();

    if (result) {
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
            <div v-if="error || success" class="mb-6">
                <Alert v-if="error" variant="destructive" class="mb-4">
                    <AlertDescription>{{ error }}</AlertDescription>
                </Alert>
                <Alert v-if="success" class="mb-4 border-green-200 bg-green-50 text-green-800">
                    <AlertDescription>{{ success }}</AlertDescription>
                </Alert>
            </div>

            <div class="space-y-8">
                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[0].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductBasicInfo
                            v-model:name="formData.name"
                            v-model:description="formData.description"
                            v-model:short_description="formData.short_description"
                        />
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[1].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductPricing
                            v-model:price="formData.price"
                            v-model:cost="formData.cost_price"
                            v-model:stock="formData.stock"
                            v-model:sku="formData.sku"
                        />
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[2].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductMedia v-model:thumbnail="formData.thumbnail" v-model:images="formData.images" v-model:rating="formData.rating" />
                    </div>
                </div>

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
                            <span>{{ isSubmitting ? 'Creating Product...' : 'Create Product' }}</span>
                        </div>
                    </Button>
                </div>
            </div>
        </div>
    </Form>
</template>
