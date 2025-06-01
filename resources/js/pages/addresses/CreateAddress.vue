<script setup lang="ts">
import AddressForm from '@/components/addresses/AddressForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Address',
        href: '/addresses/create',
    },
];

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

const handleSubmit = (formData: AddressApiData) => {
    router.post('/api/addresses', formData as unknown as Record<string, any>);
};

const handleCancel = () => {
    router.visit('/addresses');
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Register Address" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Register Address</h2>
                <p class="text-muted-foreground">Fill in the information below to register a new address</p>
            </div>

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1 lg:max-w-3xl">
                    <AddressForm submit-endpoint="/api/addresses" @submit="handleSubmit" @cancel="handleCancel" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
