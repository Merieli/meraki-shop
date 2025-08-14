<script setup lang="ts">
import { FormControl, FormItem, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Field } from 'vee-validate';
import { Label } from '../ui/label';
</script>

<template>
    <div class="space-y-4">
        <Field name="price" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="price">Price</Label>
                <FormControl>
                    <Input v-model="field.value" type="number" min="0" step="0.01" placeholder="0.00" @change="handleChange" @blur="handleBlur" />
                </FormControl>
                <FormMessage name="price" />
            </FormItem>
        </Field>

        <Field name="cost_price" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="cost_price">Cost Price</Label>
                <FormControl>
                    <Input v-model="field.value" type="number" placeholder="0.00" @change="handleChange" @blur="handleBlur" />
                </FormControl>
            </FormItem>
            <FormMessage name="cost_price" />
        </Field>

        <Field name="stock" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="stock">Stock</Label>
                <FormControl>
                    <Input v-model="field.value" @change="handleChange" @blur="handleBlur" type="number" step="1" placeholder="0" />
                </FormControl>
            </FormItem>
            <FormMessage name="stock" />
        </Field>

        <Field name="sku" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="sku">SKU</Label>
                <FormControl>
                    <Input v-model="field.value" @change="handleChange" @blur="handleBlur" placeholder="Product SKU" />
                </FormControl>
            </FormItem>
            <FormMessage name="sku" />
        </Field>
    </div>
</template>
