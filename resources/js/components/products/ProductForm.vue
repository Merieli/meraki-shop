<script setup lang="ts">
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { ProductForm } from '@/types/product';
import { Form } from 'vee-validate';
import ProductBasicInfo from './ProductBasicInfo.vue';
import ProductMedia from './ProductMedia.vue';
import ProductPricingAndInventory from './ProductPricingAndInventory.vue';
import { useProductForm } from './useProductForm';

const emit = defineEmits<{
    (e: 'cancel'): void;
}>();

const { formData, error, success, veeProductSchema, submitProduct } = useProductForm();

const onSubmit = async (values: unknown) => {
    await submitProduct(values as ProductForm);
};

const sections = [
    { id: 'basic', title: 'Basic Information' },
    { id: 'pricing', title: 'Pricing & Inventory' },
    { id: 'media', title: 'Media & Rating' },
];
</script>

<template>
    <Form :validation-schema="veeProductSchema" :initial-values="formData" v-slot="{ meta, isSubmitting }" @submit="onSubmit">
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
                        <ProductBasicInfo />
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[1].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductPricingAndInventory />
                    </div>
                </div>

                <div>
                    <h3 class="mb-4 text-lg font-medium">{{ sections[2].title }}</h3>
                    <div class="rounded-md border p-4">
                        <ProductMedia />
                    </div>
                </div>

                <!-- Form actions -->
                <div class="flex justify-end space-x-4 pt-4">
                    <Button type="button" variant="outline" @click="emit('cancel')" :disabled="isSubmitting">Cancel</Button>
                    <Button
                        type="submit"
                        :disabled="!meta.valid"
                        :class="{
                            'cursor-not-allowed opacity-75': !meta.valid,
                            'bg-green-600 hover:bg-green-700': meta.valid,
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
