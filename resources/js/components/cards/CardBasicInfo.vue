<script setup lang="ts">
import { FormControl, FormDescription, FormItem, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { cardBrands } from '@/types/card';
import { Field } from 'vee-validate';
import { Label } from '../ui/label';
</script>

<template>
    <div class="space-y-4">
        <!-- Card Number -->
        <Field name="card_number" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Card Number</Label>
                <FormControl>
                    <Input
                        v-model="field.value"
                        @input="handleChange"
                        @blur="handleBlur"
                        placeholder="Enter your card number"
                        maxlength="23"
                        autocomplete="cc-number"
                    />
                </FormControl>
                <FormDescription>Enter the number on the front of your card.</FormDescription>
                <FormMessage name="card_number" />
            </FormItem>
        </Field>

        <!-- Cardholder Name -->
        <Field name="cardholder_name" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Cardholder Name</Label>
                <FormControl>
                    <Input
                        v-model="field.value"
                        @input="handleChange"
                        @blur="handleBlur"
                        placeholder="Name as it appears on the card"
                        autocomplete="cc-name"
                    />
                </FormControl>
                <FormMessage name="cardholder_name" />
            </FormItem>
        </Field>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <!-- Expiration Date -->
            <Field name="expiration_date" v-slot="{ field, handleChange, handleBlur }">
                <FormItem>
                    <Label>Expiration Date</Label>
                    <FormControl>
                        <Input
                            v-model="field.value"
                            @input="handleChange"
                            @blur="handleBlur"
                            placeholder="MM/YY"
                            maxlength="5"
                            autocomplete="cc-exp"
                        />
                    </FormControl>
                    <FormMessage name="expiration_date" />
                </FormItem>
            </Field>

            <!-- CVV -->
            <Field name="cvv" v-slot="{ field, handleChange, handleBlur }">
                <FormItem>
                    <Label>CVV</Label>
                    <FormControl>
                        <Input
                            v-model="field.value"
                            @input="handleChange"
                            @blur="handleBlur"
                            placeholder="3 or 4 digits"
                            maxlength="4"
                            autocomplete="cc-csc"
                        />
                    </FormControl>
                    <FormMessage name="cvv" />
                </FormItem>
            </Field>
        </div>

        <!-- Card Brand -->
        <Field name="card_brand" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Card Brand</Label>
                <FormControl>
                    <Select v-model="field.value" @change="handleChange" @blur="handleBlur">
                        <SelectTrigger>
                            <SelectValue placeholder="Select card brand">
                                {{ field.value }}
                            </SelectValue>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="brand in cardBrands" :key="brand.value" :value="brand.value">
                                {{ brand.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </FormControl>
                <FormMessage name="card_brand" />
            </FormItem>
        </Field>
    </div>
</template>
