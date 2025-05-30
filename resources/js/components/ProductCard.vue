<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';

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

const formatPrice = (price: number): string => {
    return price.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
    });
};
</script>

<template>
    <Card class="overflow-hidden">
        <div class="aspect-square w-full overflow-hidden">
            <img :src="product.image" :alt="product.name" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" />
        </div>
        <CardHeader class="p-4">
            <div class="flex items-start justify-between">
                <CardTitle class="text-lg">{{ product.name }}</CardTitle>
                <Badge variant="outline">{{ product.category }}</Badge>
            </div>
        </CardHeader>
        <CardContent class="p-4 pt-0">
            <p class="text-primary text-xl font-semibold">{{ formatPrice(product.price) }}</p>
            <p v-if="!product.inStock" class="mt-1 text-sm text-red-500">Fora de estoque</p>
        </CardContent>
        <CardFooter class="flex justify-between p-4 pt-0">
            <Button variant="outline" size="sm"> Detalhes </Button>
            <Button size="sm" :disabled="!product.inStock"> Adicionar </Button>
        </CardFooter>
    </Card>
</template>
