<script setup lang="ts">
import ProductForm from '@/components/products/ProductForm.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { type ProductApiData } from '@/types/product';
import { Head, router } from '@inertiajs/vue3';
import { useProductPage } from './useProductPage';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Product',
        href: '/products/create',
    },
];

const { isSubmitting, error, success, formKey, createProduct } = useProductPage();

const handleSubmit = async (formData: ProductApiData) => {
    await createProduct(formData);
};

const handleCancel = () => {
    router.visit('/products');
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Create Product" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Create Product</h2>
                <p class="text-muted-foreground">Fill in the information below to create a new product</p>
            </div>

            <!-- Mensagens de erro/sucesso -->
            <Alert v-if="error" variant="destructive">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"
                    />
                </svg>
                <AlertTitle>Error</AlertTitle>
                <AlertDescription>{{ error }}</AlertDescription>
            </Alert>

            <Alert v-if="success" variant="success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                <AlertTitle>Success</AlertTitle>
                <AlertDescription>{{ success }}</AlertDescription>
            </Alert>

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1 lg:max-w-3xl">
                    <ProductForm
                        :key="formKey"
                        submit-endpoint="/api/products"
                        @submit="handleSubmit"
                        @cancel="handleCancel"
                        :disabled="isSubmitting"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
