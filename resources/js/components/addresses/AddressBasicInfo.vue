<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import type { FormErrors } from '@/utils/formValidation';

interface Props {
    formData: {
        label: string;
        recipient_name: string;
        street: string;
        number: string;
        neighborhood: string;
        complement: string;
        city: string;
        state: string;
        country: string;
        postal_code: string;
    };
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="space-y-4">
        <!-- Label -->
        <FormField name="label">
            <FormItem>
                <FormLabel>Label</FormLabel>
                <FormControl>
                    <Input v-model="formData.label" @blur="validateField('label', formData.label)" placeholder="Home, Work, etc." />
                </FormControl>
                <FormDescription>Give a name to identify this address.</FormDescription>
                <FormMessage v-if="errors.label">{{ errors.label }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Recipient Name -->
        <FormField name="recipient_name">
            <FormItem>
                <FormLabel>Recipient Name</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.recipient_name"
                        @blur="validateField('recipient_name', formData.recipient_name)"
                        placeholder="Full name of the recipient"
                    />
                </FormControl>
                <FormDescription>Name of the person who will receive deliveries at this address.</FormDescription>
                <FormMessage v-if="errors.recipient_name">{{ errors.recipient_name }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Street -->
        <FormField name="street">
            <FormItem>
                <FormLabel>Street/Avenue</FormLabel>
                <FormControl>
                    <Input v-model="formData.street" @blur="validateField('street', formData.street)" placeholder="Street or avenue name" />
                </FormControl>
                <FormMessage v-if="errors.street">{{ errors.street }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Number -->
        <FormField name="number">
            <FormItem>
                <FormLabel>Number</FormLabel>
                <FormControl>
                    <Input v-model="formData.number" @blur="validateField('number', formData.number)" placeholder="Address number" />
                </FormControl>
                <FormMessage v-if="errors.number">{{ errors.number }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Neighborhood -->
        <FormField name="neighborhood">
            <FormItem>
                <FormLabel>Neighborhood</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.neighborhood"
                        @blur="validateField('neighborhood', formData.neighborhood)"
                        placeholder="Neighborhood name"
                    />
                </FormControl>
                <FormMessage v-if="errors.neighborhood">{{ errors.neighborhood }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Complement -->
        <FormField name="complement">
            <FormItem>
                <FormLabel>Complement</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.complement"
                        @blur="validateField('complement', formData.complement)"
                        placeholder="Apartment, block, reference, etc."
                    />
                </FormControl>
                <FormMessage v-if="errors.complement">{{ errors.complement }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- City -->
        <FormField name="city">
            <FormItem>
                <FormLabel>City</FormLabel>
                <FormControl>
                    <Input v-model="formData.city" @blur="validateField('city', formData.city)" placeholder="City name" />
                </FormControl>
                <FormMessage v-if="errors.city">{{ errors.city }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- State -->
        <FormField name="state">
            <FormItem>
                <FormLabel>State</FormLabel>
                <FormControl>
                    <Input v-model="formData.state" @blur="validateField('state', formData.state)" placeholder="State name" />
                </FormControl>
                <FormMessage v-if="errors.state">{{ errors.state }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Country -->
        <FormField name="country">
            <FormItem>
                <FormLabel>Country</FormLabel>
                <FormControl>
                    <Input v-model="formData.country" @blur="validateField('country', formData.country)" placeholder="Country name" />
                </FormControl>
                <FormMessage v-if="errors.country">{{ errors.country }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Postal Code -->
        <FormField name="postal_code">
            <FormItem>
                <FormLabel>Postal Code</FormLabel>
                <FormControl>
                    <Input v-model="formData.postal_code" @blur="validateField('postal_code', formData.postal_code)" placeholder="Postal code" />
                </FormControl>
                <FormMessage v-if="errors.postal_code">{{ errors.postal_code }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
