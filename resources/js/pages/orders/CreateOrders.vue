<script setup lang="ts">
import type { OrderData } from '@/components/orders/OrderCard.vue';
import OrdersList from '@/components/orders/OrdersList.vue';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { apiService } from '@/utils/api';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'My Orders',
        href: '/orders',
    },
];

const orders = ref<OrderData[]>([]);
const isLoading = ref(true);
const error = ref<string | null>(null);
const success = ref<string | null>(null);

const fetchOrders = async () => {
    isLoading.value = true;
    error.value = null;

    try {
        const response = await apiService.list<OrderData[]>('order', {}, true);
        orders.value = response;
        success.value = 'Orders loaded successfully!';
    } catch (err: any) {
        console.error('Error fetching orders:', err);
        error.value = err.response?.data?.message || 'An error occurred while fetching your orders. Please try again.';
        orders.value = [];
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchOrders();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="My Orders" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">My Orders</h2>
                <p class="text-muted-foreground">View and track all your orders</p>
            </div>

            <!-- Error/Success messages -->
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
                <div class="flex-1">
                    <OrdersList :orders="orders" :loading="isLoading" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
