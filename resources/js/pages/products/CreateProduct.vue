<script setup lang="ts">
import ProductForm from '@/components/products/ProductForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { useProductPage } from './useProductPage';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Product',
        href: '/products/create',
    },
];

const { isSubmitting, formKey } = useProductPage();

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

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1 lg:max-w-3xl">
                    <ProductForm :key="formKey" @cancel="handleCancel" :disabled="isSubmitting" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
