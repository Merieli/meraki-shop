<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { cardBrands, type CardFormData } from '@/types/card';
import type { FormErrors } from '@/utils/formValidation';

interface Props {
    formData: CardFormData;
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();

/**
 * Formata o número do cartão
 * @param e Evento do input
 */
const formatCardNumber = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');

    if (value.length > 19) {
        value = value.slice(0, 19);
    }
    const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');

    props.formData.card_number = formatted;
};

/**
 * Formata a data de validade do cartão
 * @param e Evento do input
 */
const formatExpiryDate = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');

    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }

    props.formData.expiration_date = value;
};

const formatCVV = (e: Event) => {
    const input = e.target as HTMLInputElement;
    const value = input.value.replace(/\D/g, '');

    props.formData.cvv = value.slice(0, 4);
};
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
                        @input="formatCardNumber"
                        @blur="validateField('card_number', formData.card_number.replace(/\s+/g, ''))"
                        placeholder="Enter your card number"
                        maxlength="23"
                        autocomplete="cc-number"
                    />
                </FormControl>
                <FormDescription>Enter the number on the front of your card.</FormDescription>
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
                        autocomplete="cc-name"
                    />
                </FormControl>
                <FormMessage v-if="errors.cardholder_name">{{ errors.cardholder_name }}</FormMessage>
            </FormItem>
        </FormField>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <!-- Expiration Date -->
            <FormField name="expiration_date">
                <FormItem>
                    <FormLabel>Expiration Date</FormLabel>
                    <FormControl>
                        <Input
                            v-model="formData.expiration_date"
                            @input="formatExpiryDate"
                            @blur="validateField('expiration_date', formData.expiration_date)"
                            placeholder="MM/YY"
                            maxlength="5"
                            autocomplete="cc-exp"
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
                            @input="formatCVV"
                            @blur="validateField('cvv', formData.cvv)"
                            placeholder="3 or 4 digits"
                            maxlength="4"
                            autocomplete="cc-csc"
                        />
                    </FormControl>
                    <FormMessage v-if="errors.cvv">{{ errors.cvv }}</FormMessage>
                </FormItem>
            </FormField>
        </div>

        <!-- Card Brand -->
        <FormField name="card_brand">
            <FormItem>
                <FormLabel>Card Brand</FormLabel>
                <FormControl>
                    <Select v-model="formData.card_brand" @blur="validateField('card_brand', formData.card_brand)">
                        <SelectTrigger>
                            <SelectValue placeholder="Select card brand" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="brand in cardBrands" :key="brand.value" :value="brand.value">
                                {{ brand.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </FormControl>
                <FormDescription>Selecione a bandeira do seu cartão.</FormDescription>
                <FormMessage v-if="errors.card_brand">{{ errors.card_brand }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
