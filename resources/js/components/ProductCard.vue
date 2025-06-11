<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Product } from '@/types/product';
import { apiService } from '@/utils/api';
import { formatCurrency, toCents } from '@/utils/money';
import { usePage } from '@inertiajs/vue3';
import { LogIn, ShoppingCart } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
    product: Product;
}>();

const page = usePage<{ auth?: { user: any } }>();
const isLoggedIn = computed(() => !!page.props.auth?.user);

const isCreatingOrder = ref(false);
const orderStatusMessage = ref<string | null>(null);
const orderStatusType = ref<'success' | 'error' | null>(null);

const handleBuyClick = async (e: Event) => {
    if (!isLoggedIn.value) {
        e.preventDefault();
        window.location.href = route('login');
        return;
    }

    isCreatingOrder.value = true;
    orderStatusMessage.value = null;
    orderStatusType.value = null;

    try {
        const orderData = {
            product_id: props.product.id,
            unit_price: toCents(props.product.price),
            status: 'pending',
            payment_method: 'Credit Card', // Placeholder
        };

        await apiService.create('order', orderData, true);

        orderStatusType.value = 'success';
        orderStatusMessage.value = 'Order created! Check "My Orders" for details.';
    } catch (err: any) {
        orderStatusType.value = 'error';
        orderStatusMessage.value = err.response?.data?.message || 'Failed to create order.';
        console.error('Error creating order:', err);
    } finally {
        isCreatingOrder.value = false;
    }
};
</script>

<template>
    <Card class="flex flex-col overflow-hidden">
        <div class="aspect-square w-full overflow-hidden">
            <img :src="product.thumbnail" :alt="product.name" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>
        <CardHeader class="p-4">
            <CardTitle class="text-lg">{{ product.name }}</CardTitle>
        </CardHeader>
        <CardContent class="flex-grow p-4 pt-0">
            <p class="text-muted-foreground text-sm">{{ product.shortDescription }}</p>
        </CardContent>
        <CardFooter class="mt-auto flex flex-col items-start gap-4 p-4 pt-0">
            <div class="w-full">
                <div class="flex w-full items-center justify-between">
                    <span class="text-2xl font-bold">{{ formatCurrency(product.price) }}</span>
                    <div class="flex items-center gap-1">
                        <span class="text-sm">{{ product.rating }}</span>
                        <svg class="h-4 w-4 fill-yellow-500" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">Shipping included</p>
            </div>

            <!-- Order Status Message -->
            <div
                v-if="orderStatusMessage"
                :class="[
                    'w-full rounded-md p-3 text-sm',
                    orderStatusType === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '',
                    orderStatusType === 'error' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '',
                ]"
            >
                {{ orderStatusMessage }}
            </div>

            <Button @click="handleBuyClick" class="w-full" :disabled="isCreatingOrder">
                <template v-if="isCreatingOrder">
                    <div class="h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"></div>
                </template>
                <template v-else-if="isLoggedIn">
                    <ShoppingCart class="mr-2 h-4 w-4" />
                    Buy with click
                </template>
                <template v-else>
                    <LogIn class="mr-2 h-4 w-4" />
                    Login to Buy
                </template>
            </Button>
        </CardFooter>
    </Card>
</template>
