<script setup lang="ts">
import { Button } from '@/components/ui/button';
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

const { formData, isSubmitting, errors, validateField, validateAll, convertToApiFormat } = useProductForm(props.initialData);

const isButtonDisabled = computed(() => isSubmitting.value || props.disabled);

const submitForm = async () => {
    if (!validateAll(formData.value)) return;

    isSubmitting.value = true;
    await submitValidForm();
    isSubmitting.value = false;
};

const submitValidForm = async () => {
    try {
        const apiData = convertToApiFormat(formData.value);
        emit('submit', apiData);
    } catch (error) {
        console.error('Error submitting form:', error);
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
