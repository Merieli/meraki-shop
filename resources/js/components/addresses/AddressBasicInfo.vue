<script setup lang="ts">
import { FormControl, FormItem, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Field } from 'vee-validate';
import { Label } from '../ui/label';
</script>

<template>
    <div class="space-y-4">
        <!-- Label -->
        <Field name="label" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Label</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Home, Work, etc." />
                </FormControl>
                <FormMessage name="label" />
            </FormItem>
        </Field>

        <!-- Recipient Name -->
        <Field name="recipient_name" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Recipient Name</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Full name of the recipient" />
                </FormControl>
                <FormMessage name="recipient_name" />
            </FormItem>
        </Field>

        <!-- Street -->
        <Field name="street" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Street/Avenue</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Street or avenue name" />
                </FormControl>
                <FormMessage name="street" />
            </FormItem>
        </Field>

        <!-- Number -->
        <Field name="number" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Number</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Address number" />
                </FormControl>
                <FormMessage name="number" />
            </FormItem>
        </Field>

        <!-- Neighborhood -->
        <Field name="neighborhood" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Neighborhood</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Neighborhood name" />
                </FormControl>
                <FormMessage name="neighborhood" />
            </FormItem>
        </Field>

        <!-- Complement -->
        <Field name="complement" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Complement</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Apartment, block, reference, etc." />
                </FormControl>
                <FormMessage name="complement" />
            </FormItem>
        </Field>

        <!-- City -->
        <Field name="city" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>City</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="City name" />
                </FormControl>
                <FormMessage name="city" />
            </FormItem>
        </Field>

        <!-- State -->
        <Field name="state" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>State</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="State name" />
                </FormControl>
                <FormMessage name="state" />
            </FormItem>
        </Field>

        <!-- Country -->
        <Field name="country" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Country</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Country name" />
                </FormControl>
                <FormMessage name="country" />
            </FormItem>
        </Field>

        <!-- Postal Code -->
        <Field name="postal_code" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Postal Code</Label>
                <FormControl>
                    <Input v-model="field.value" @input="handleChange" @blur="handleBlur" placeholder="Postal code" />
                </FormControl>
                <FormMessage name="postal_code" />
            </FormItem>
        </Field>
    </div>
</template>
