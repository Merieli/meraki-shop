<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import type { FormErrors } from '@/utils/formValidation';
import { computed } from 'vue';

interface Props {
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();

const price = defineModel<number>('price', { required: true });
const cost = defineModel<number>('cost', { required: true });
const stock = defineModel<number>('stock', { required: true });
const sku = defineModel<string>('sku', { required: true });

// Computed properties para determinar o estado de cada campo
const priceStatus = computed(() => {
    if (price.value === undefined || price.value === null) return 'default';
    return props.errors.price ? 'error' : 'success';
});

const costStatus = computed(() => {
    if (cost.value === undefined || cost.value === null) return 'default';
    return props.errors.cost_price ? 'error' : 'success';
});

const stockStatus = computed(() => {
    if (stock.value === undefined || stock.value === null) return 'default';
    return props.errors.stock ? 'error' : 'success';
});

const skuStatus = computed(() => {
    if (!sku.value) return 'default';
    return props.errors.sku ? 'error' : 'success';
});

// Funções para validação em tempo real
const validatePriceField = (value: number) => {
    props.validateField('price', value);
};

const validateCostField = (value: number) => {
    props.validateField('cost_price', value);
};

const validateStockField = (value: number) => {
    props.validateField('stock', value);
};

const validateSkuField = (value: string) => {
    props.validateField('sku', value);
};

// Classes dinâmicas para os inputs baseadas no estado
const getInputClasses = (status: string) => {
    const baseClasses = 'transition-colors duration-200';
    switch (status) {
        case 'error':
            return `${baseClasses} border-red-500 focus:border-red-500 focus:ring-red-500`;
        case 'success':
            return `${baseClasses} border-green-500 focus:border-green-500 focus:ring-green-500`;
        default:
            return baseClasses;
    }
};
</script>

<template>
    <div class="space-y-4">
        <!-- Price -->
        <FormField name="price">
            <FormItem>
                <FormLabel>Price</FormLabel>
                <FormControl>
                    <Input
                        v-model="price"
                        @input="validatePriceField(price)"
                        @blur="validatePriceField(price)"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        :class="getInputClasses(priceStatus)"
                    />
                </FormControl>
                <FormDescription>Set the price for your product.</FormDescription>
                <FormMessage v-if="errors.price" class="mt-1 text-sm text-red-500">{{ errors.price }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Cost -->
        <FormField name="cost">
            <FormItem>
                <FormLabel>Cost Price</FormLabel>
                <FormControl>
                    <Input
                        v-model="cost"
                        @input="validateCostField(cost)"
                        @blur="validateCostField(cost)"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        :class="getInputClasses(costStatus)"
                    />
                </FormControl>
                <FormDescription>Set the cost price for your product.</FormDescription>
                <FormMessage v-if="errors.cost_price" class="mt-1 text-sm text-red-500">{{ errors.cost_price }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Stock -->
        <FormField name="stock">
            <FormItem>
                <FormLabel>Stock</FormLabel>
                <FormControl>
                    <Input
                        v-model="stock"
                        @input="validateStockField(stock)"
                        @blur="validateStockField(stock)"
                        type="number"
                        min="0"
                        step="1"
                        placeholder="0"
                        :class="getInputClasses(stockStatus)"
                    />
                </FormControl>
                <FormDescription>Set the stock quantity for your product.</FormDescription>
                <FormMessage v-if="errors.stock" class="mt-1 text-sm text-red-500">{{ errors.stock }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- SKU -->
        <FormField name="sku">
            <FormItem>
                <FormLabel>SKU</FormLabel>
                <FormControl>
                    <Input
                        v-model="sku"
                        @input="validateSkuField(sku)"
                        @blur="validateSkuField(sku)"
                        placeholder="Product SKU"
                        :class="getInputClasses(skuStatus)"
                    />
                </FormControl>
                <FormDescription>SKU code for product identification.</FormDescription>
                <FormMessage v-if="errors.sku" class="mt-1 text-sm text-red-500">{{ errors.sku }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
