<script setup lang="ts">
import CardForm from '@/components/cards/CardForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Card',
        href: '/cards/create',
    },
];

interface CardApiData {
    card_number: string;
    cardholder_name: string;
    expiration_date: string;
    cvv: string;
    card_brand: string;
}

const handleSubmit = (formData: CardApiData) => {
    router.post('/api/cards', formData as unknown as Record<string, any>);
};

const handleCancel = () => {
    router.visit('/cards');
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Register Card" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Register Card</h2>
                <p class="text-muted-foreground">Fill in the information below to register a new payment card</p>
            </div>

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1 lg:max-w-3xl">
                    <CardForm submit-endpoint="/api/cards" @submit="handleSubmit" @cancel="handleCancel" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
