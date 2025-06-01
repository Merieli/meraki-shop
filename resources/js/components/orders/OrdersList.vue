<script setup lang="ts">
import { computed } from 'vue';
import type { OrderData } from './OrderCard.vue';
import OrderCard from './OrderCard.vue';

interface Props {
    orders: OrderData[];
    loading?: boolean;
}

const props = defineProps<Props>();

const hasOrders = computed(() => props.orders.length > 0);
</script>

<template>
    <div>
        <div v-if="loading" class="py-8 text-center">
            <div class="border-primary mx-auto mb-4 h-8 w-8 animate-spin rounded-full border-4 border-t-transparent"></div>
            <p class="text-muted-foreground">Loading orders...</p>
        </div>

        <div v-else-if="!hasOrders" class="py-12 text-center">
            <h3 class="mb-2 text-xl font-semibold">No orders found</h3>
            <p class="text-muted-foreground">You haven't placed any orders yet.</p>
        </div>

        <div v-else class="space-y-4">
            <OrderCard v-for="order in orders" :key="order.id" :order="order" />
        </div>
    </div>
</template>
