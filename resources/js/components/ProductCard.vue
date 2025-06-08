<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { formatCurrency } from '@/utils/money';
import { usePage } from '@inertiajs/vue3';
import { LogIn } from 'lucide-vue-next';
import { computed } from 'vue';

interface Product {
    id: number;
    name: string;
    price: number;
    category: string;
    image: string;
    inStock: boolean;
}

defineProps<{
    product: Product;
}>();

const isLoggedIn = computed(() => {
    // @ts-ignore - Acessando a propriedade dinamicamente
    return !!usePage().props.auth && !!usePage().props.auth.user;
});

const formatPrice = (price: number): string => {
    return formatCurrency(price);
};

const handleBuyClick = (e: Event) => {
    if (!isLoggedIn.value) {
        e.preventDefault();
        window.location.href = route('login');
    }
};
</script>

<template>
    <Card class="flex h-full flex-col overflow-hidden">
        <div class="aspect-square w-full overflow-hidden">
            <img :src="product.image" :alt="product.name" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>
        <CardHeader class="p-4">
            <CardTitle class="text-lg font-medium text-[#1b1b18] dark:text-white">{{ product.name }}</CardTitle>
        </CardHeader>
        <CardContent class="flex-grow p-4 pt-0">
            <div class="flex flex-col">
                <p class="text-xl font-semibold text-[#1b1b18] dark:text-white">{{ formatPrice(product.price) }}</p>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">Shipping included</p>
                <p v-if="!product.inStock" class="mt-1 text-sm text-red-500 dark:text-red-400">Out of stock</p>
            </div>
        </CardContent>
        <CardFooter class="mt-auto flex justify-center p-4 pt-0">
            <HoverCard v-if="!isLoggedIn">
                <HoverCardTrigger asChild>
                    <Button
                        size="sm"
                        :disabled="!product.inStock"
                        class="w-full bg-[#1b1b18] text-white hover:bg-[#333] dark:bg-[#f0f0f0] dark:text-[#1b1b18] dark:hover:bg-white"
                        @click="handleBuyClick"
                    >
                        Buy with 1-Click
                    </Button>
                </HoverCardTrigger>
                <HoverCardContent class="w-auto">
                    <div class="flex items-center gap-2">
                        <LogIn class="text-primary h-4 w-4" />
                        <span class="text-sm">Login required</span>
                    </div>
                </HoverCardContent>
            </HoverCard>

            <Button
                v-else
                size="sm"
                :disabled="!product.inStock"
                class="w-full bg-[#1b1b18] text-white hover:bg-[#333] dark:bg-[#f0f0f0] dark:text-[#1b1b18] dark:hover:bg-white"
            >
                Buy with 1-Click
            </Button>
        </CardFooter>
    </Card>
</template>
