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

// Formatação do número do cartão (adiciona espaços a cada 4 dígitos)
const formatCardNumber = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');

    // Limita a 19 dígitos
    if (value.length > 19) {
        value = value.slice(0, 19);
    }

    // Adiciona espaços a cada 4 dígitos
    const formatted = value.replace(/(\d{4})(?=\d)/g, '$1 ');

    // Atualiza o valor
    props.formData.card_number = formatted;

    // Detecta a bandeira do cartão
    detectCardBrand(value);
};

// Formatação da data de validade (formato MM/YY)
const formatExpiryDate = (e: Event) => {
    const input = e.target as HTMLInputElement;
    let value = input.value.replace(/\D/g, '');

    // Limita a 4 dígitos
    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    // Formata como MM/YY
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2);
    }

    // Atualiza o valor
    props.formData.expiration_date = value;
};

// Detecta a bandeira do cartão baseado nos primeiros dígitos
const detectCardBrand = (cardNumber: string) => {
    const cleanNumber = cardNumber.replace(/\D/g, '');

    // Visa: começa com 4
    if (/^4/.test(cleanNumber)) {
        props.formData.card_brand = 'Visa';
    }
    // Mastercard: começa com 51-55 ou 2221-2720
    else if (/^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[0-1]|2720)/.test(cleanNumber)) {
        props.formData.card_brand = 'Mastercard';
    }
    // American Express: começa com 34 ou 37
    else if (/^3[47]/.test(cleanNumber)) {
        props.formData.card_brand = 'American Express';
    }
    // Discover: começa com 6011, 622126-622925, 644-649, 65
    else if (/^(6011|65|64[4-9]|622(12[6-9]|1[3-9]|[2-8]|9[01]|92[0-5]))/.test(cleanNumber)) {
        props.formData.card_brand = 'Discover';
    }
    // Elo: padrões específicos para cartões Elo
    else if (
        /^(4011(78|79)|43(1274|8935)|45(1416|7393|763(1|2))|50(4175|6699|67[0-7][0-9]|9000)|627780|63(6297|6368)|650(03([^4])|04([0-9])|05(0|1)|4(0[5-9]|3[0-9]|8[5-9]|9[0-9])|5([0-2][0-9]|3[0-8])|9([2-6][0-9]|7[0-8])|541|700|720|901)|651652|655000|655021)/.test(
            cleanNumber,
        )
    ) {
        props.formData.card_brand = 'Elo';
    }
    // Hipercard: começa com 606282
    else if (/^(606282)/.test(cleanNumber)) {
        props.formData.card_brand = 'Hipercard';
    }
    // Diners Club: começa com 36, 38, 39, 54, 55
    else if (/^(36|38|39|54|55)/.test(cleanNumber)) {
        props.formData.card_brand = 'Diners Club';
    }
    // JCB: começa com 35
    else if (/^(35)/.test(cleanNumber)) {
        props.formData.card_brand = 'JCB';
    }
    // Se não reconhecer, limpa o campo
    else if (cleanNumber.length >= 6) {
        props.formData.card_brand = 'Other';
    } else {
        props.formData.card_brand = '';
    }
};

// Formata apenas números para o CVV
const formatCVV = (e: Event) => {
    const input = e.target as HTMLInputElement;
    const value = input.value.replace(/\D/g, '');

    // Limita a 4 dígitos
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
                <FormDescription>This field is auto-detected from your card number, but you can change it if needed.</FormDescription>
                <FormMessage v-if="errors.card_brand">{{ errors.card_brand }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
