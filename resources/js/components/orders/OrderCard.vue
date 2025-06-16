<script setup lang="ts">
import { formatDate } from '@/utils/formatters';
import { formatCurrency } from '@/utils/money';
import { ChevronDown, ChevronUp } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import type { OrderItemData } from './OrderItem.vue';
import OrderItem from './OrderItem.vue';

export interface OrderData {
    id: number;
    status: string;
    payment_method: string;
    created_at: string;
    updated_at: string;
    order_items: OrderItemData[];
}

const props = defineProps<{
    order: OrderData;
}>();

const isExpanded = ref(false);
const toggleExpand = () => {
    isExpanded.value = !isExpanded.value;
};

const hasItems = computed(() => props.order.order_items && props.order.order_items.length > 0);

const getTotalAmount = (): number => {
    if (!hasItems.value) return 0;

    return props.order.order_items.reduce((total, item) => {
        return total + item.unit_price * item.quantity;
    }, 0);
};

const getStatusColor = (): string => {
    switch (props.order.status) {
        case 'completed':
            return 'text-green-600';
        case 'processing':
            return 'text-blue-600';
        case 'cancelled':
            return 'text-red-600';
        default:
            return 'text-yellow-600'; // pending
    }
};

const getStatusText = (): string => {
    const status = props.order.status;
    return status.charAt(0).toUpperCase() + status.slice(1);
};
</script>

<template>
    <div class="bg-card text-card-foreground mb-4 rounded-lg border shadow-sm">
        <div class="flex cursor-pointer items-center justify-between p-4" @click="toggleExpand">
            <div>
                <div class="mb-1 text-sm">Order #{{ order.id }}</div>
                <div class="font-semibold">{{ formatDate(order.created_at) }}</div>
            </div>
            <div class="flex flex-col items-end">
                <div class="font-semibold">{{ formatCurrency(getTotalAmount(), 'USD', true) }}</div>
                <div :class="getStatusColor()" class="text-sm">{{ getStatusText() }}</div>
            </div>
            <div class="ml-4">
                <ChevronDown v-if="!isExpanded" class="h-5 w-5" />
                <ChevronUp v-else class="h-5 w-5" />
            </div>
        </div>

        <div v-if="isExpanded" class="border-t p-4">
            <div class="mb-4">
                <div class="text-muted-foreground mb-1 text-sm">Payment Method</div>
                <div>{{ order.payment_method }}</div>
            </div>

            <div v-if="hasItems" class="mb-4">
                <div class="text-muted-foreground mb-2 text-sm">Order Items</div>
                <div class="space-y-1">
                    <OrderItem v-for="item in order.order_items" :key="item.id" :item="item" />
                </div>
            </div>
            <div v-else class="text-muted-foreground mb-4 text-center">
                <p>No items in this order</p>
            </div>

            <div class="flex justify-between border-t pt-2 font-semibold">
                <span>Total</span>
                <span>{{ formatCurrency(getTotalAmount(), 'USD', true) }}</span>
            </div>
        </div>
    </div>
</template>
