<script setup lang="ts">
import type { OrderData } from '@/components/orders/OrderCard.vue';
import OrdersList from '@/components/orders/OrdersList.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'My Orders',
        href: '/orders',
    },
];

// This would typically come from the backend via Inertia props
const orders = ref<OrderData[]>([]);
const isLoading = ref(true);

const dummyOrders: OrderData[] = [
    {
        id: 1,
        status: 'completed',
        payment_method: 'Credit Card',
        created_at: '2023-06-15T14:30:00Z',
        updated_at: '2023-06-15T14:35:00Z',
        items: [
            {
                id: 1,
                product_id: 101,
                variation_id: 201,
                product_name: 'Wireless Headphones',
                variation_name: 'Black',
                quantity: 1,
                unit_price: 12999,
            },
        ],
    },
    {
        id: 2,
        status: 'processing',
        payment_method: 'PayPal',
        created_at: '2023-07-22T09:15:00Z',
        updated_at: '2023-07-22T09:20:00Z',
        items: [
            {
                id: 2,
                product_id: 102,
                variation_id: 202,
                product_name: 'Smartphone Case',
                variation_name: 'Clear',
                quantity: 2,
                unit_price: 1999,
            },
            {
                id: 3,
                product_id: 103,
                variation_id: 203,
                product_name: 'Screen Protector',
                variation_name: 'Tempered Glass',
                quantity: 1,
                unit_price: 1499,
            },
        ],
    },
    {
        id: 3,
        status: 'pending',
        payment_method: 'Bank Transfer',
        created_at: '2023-08-05T16:45:00Z',
        updated_at: '2023-08-05T16:50:00Z',
        items: [
            {
                id: 4,
                product_id: 104,
                variation_id: 204,
                product_name: 'External Hard Drive',
                variation_name: '1TB',
                quantity: 1,
                unit_price: 8999,
            },
        ],
    },
];

onMounted(() => {
    // Simulate API call
    setTimeout(() => {
        orders.value = dummyOrders;
        isLoading.value = false;
    }, 1000);
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

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1">
                    <OrdersList :orders="orders" :loading="isLoading" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
