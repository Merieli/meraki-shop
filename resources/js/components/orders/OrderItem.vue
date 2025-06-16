<script setup lang="ts">
import { apiService } from '@/utils/api';
import { formatCurrency } from '@/utils/money';
import { onMounted, ref } from 'vue';

export interface OrderItemData {
    id: number;
    product_id: number;
    variation_id: number;
    product_name?: string;
    variation_name: string;
    quantity: number;
    unit_price: number;
}

const props = defineProps<{
    item: OrderItemData;
}>();

const productName = ref(props.item.product_name);
const isLoading = ref(false);

interface Product {
    id: number;
    name: string;
}

onMounted(async () => {
    if (!productName.value && props.item.product_id) {
        isLoading.value = true;
        try {
            const product = await apiService.get<Product>('products', props.item.product_id);
            productName.value = product.name;
        } catch (error) {
            console.error('Failed to fetch product name:', error);
            productName.value = 'Unknown Product';
        } finally {
            isLoading.value = false;
        }
    }
});
</script>

<template>
    <div class="flex items-center justify-between border-b py-3 last:border-b-0">
        <div class="flex-1">
            <h4 v-if="isLoading" class="font-medium">Loading product...</h4>
            <h4 v-else class="font-medium">{{ productName }}</h4>
            <p class="text-muted-foreground text-sm">Variant: {{ item.variation_name }}</p>
        </div>
        <div class="flex flex-col items-end">
            <span class="font-medium">{{ formatCurrency(item.unit_price, 'USD', true) }}</span>
            <span class="text-muted-foreground text-sm">Qty: {{ item.quantity }}</span>
        </div>
    </div>
</template>
