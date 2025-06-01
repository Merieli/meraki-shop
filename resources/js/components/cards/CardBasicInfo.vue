<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import type { FormErrors } from '@/utils/formValidation';

interface Props {
    formData: {
        card_number: string;
        cardholder_name: string;
        expiration_date: string;
        cvv: string;
        card_brand: string;
    };
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="space-y-4">
        <!-- Card Number -->
        <FormField name="card_number">
            <FormItem>
                <FormLabel>Card Number</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.card_number"
                        @blur="validateField('card_number', formData.card_number)"
                        placeholder="Enter your card number"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                    />
                </FormControl>
                <FormDescription>Enter the 16-digit number on your card.</FormDescription>
                <FormMessage v-if="errors.card_number">{{ errors.card_number }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Cardholder Name -->
        <FormField name="cardholder_name">
            <FormItem>
                <FormLabel>Cardholder Name</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.cardholder_name"
                        @blur="validateField('cardholder_name', formData.cardholder_name)"
                        placeholder="Name as it appears on the card"
                    />
                </FormControl>
                <FormMessage v-if="errors.cardholder_name">{{ errors.cardholder_name }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Expiration Date -->
        <FormField name="expiration_date">
            <FormItem>
                <FormLabel>Expiration Date</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.expiration_date"
                        @blur="validateField('expiration_date', formData.expiration_date)"
                        placeholder="MM/YY"
                    />
                </FormControl>
                <FormMessage v-if="errors.expiration_date">{{ errors.expiration_date }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- CVV -->
        <FormField name="cvv">
            <FormItem>
                <FormLabel>CVV</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.cvv"
                        @blur="validateField('cvv', formData.cvv)"
                        placeholder="3 or 4 digits"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                    />
                </FormControl>
                <FormDescription>The 3 or 4 digit security code on the back or front of your card.</FormDescription>
                <FormMessage v-if="errors.cvv">{{ errors.cvv }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Card Brand -->
        <FormField name="card_brand">
            <FormItem>
                <FormLabel>Card Brand</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.card_brand"
                        @blur="validateField('card_brand', formData.card_brand)"
                        placeholder="Visa, Mastercard, etc."
                    />
                </FormControl>
                <FormMessage v-if="errors.card_brand">{{ errors.card_brand }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
