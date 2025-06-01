<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import type { FormErrors } from '@/utils/formValidation';
import { formatCurrency } from '@/utils/money';
import { computed } from 'vue';

interface Props {
    formData: {
        price: number;
        cost_price: number;
        stock: number;
        sku: string;
    };
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();

const formattedPrice = computed(() => formatCurrency(props.formData.price));
const formattedCostPrice = computed(() => formatCurrency(props.formData.cost_price));
</script>

<template>
    <div class="space-y-4">
        <!-- Price -->
        <FormField name="price">
            <FormItem>
                <FormLabel>Price</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.price"
                        @blur="validateField('price', formData.price)"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                    />
                </FormControl>
                <FormDescription>Set the price for your product.</FormDescription>
                <FormMessage v-if="errors.price">{{ errors.price }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Cost Price -->
        <FormField name="cost_price">
            <FormItem>
                <FormLabel>Cost Price</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.cost_price"
                        @blur="validateField('cost_price', formData.cost_price)"
                        type="number"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                    />
                </FormControl>
                <FormDescription>Set the cost price for your product.</FormDescription>
                <FormMessage v-if="errors.cost_price">{{ errors.cost_price }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Stock -->
        <FormField name="stock">
            <FormItem>
                <FormLabel>Stock</FormLabel>
                <FormControl>
                    <Input v-model="formData.stock" @blur="validateField('stock', formData.stock)" type="number" min="0" placeholder="0" />
                </FormControl>
                <FormDescription>Set the stock quantity for your product.</FormDescription>
                <FormMessage v-if="errors.stock">{{ errors.stock }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- SKU -->
        <FormField name="sku">
            <FormItem>
                <FormLabel>SKU</FormLabel>
                <FormControl>
                    <Input v-model="formData.sku" @blur="validateField('sku', formData.sku)" placeholder="Product SKU" />
                </FormControl>
                <FormDescription>SKU code for product identification.</FormDescription>
                <FormMessage v-if="errors.sku">{{ errors.sku }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
