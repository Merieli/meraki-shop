<script setup lang="ts">
import { formatCurrency } from '@/utils/money';

export interface OrderItemData {
    id: number;
    product_id: number;
    variation_id: number;
    product_name: string;
    variation_name: string;
    quantity: number;
    unit_price: number;
}

defineProps<{
    item: OrderItemData;
}>();
</script>

<template>
    <div class="flex items-center justify-between border-b py-3 last:border-b-0">
        <div class="flex-1">
            <h4 class="font-medium">{{ item.product_name }}</h4>
            <p class="text-muted-foreground text-sm">Variant: {{ item.variation_name }}</p>
        </div>
        <div class="flex flex-col items-end">
            <span class="font-medium">{{ formatCurrency(item.unit_price, 'USD', true) }}</span>
            <span class="text-muted-foreground text-sm">Qty: {{ item.quantity }}</span>
        </div>
    </div>
</template>
