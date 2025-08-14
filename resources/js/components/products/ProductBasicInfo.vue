<script setup lang="ts">
import { FormControl, FormItem, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Field } from 'vee-validate';
import { Label } from '../ui/label';
</script>

<template>
    <div class="space-y-4">
        <Field name="name" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="name">Name</Label>
                <FormControl>
                    <Input v-model="field.value" placeholder="Name of product" @change="handleChange" @blur="handleBlur" />
                </FormControl>
                <FormMessage name="name" />
            </FormItem>
        </Field>

        <Field name="short_description" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="short_description">Short Description</Label>
                <FormControl>
                    <Input v-model="field.value" placeholder="Brief product description" @change="handleChange" @blur="handleBlur" />
                </FormControl>
                <FormMessage name="short_description" />
            </FormItem>
        </Field>

        <Field name="description" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="description">Full Description</Label>
                <FormControl>
                    <Textarea v-model="field.value" placeholder="Detailed product description" @change="handleChange" @blur="handleBlur" />
                </FormControl>
                <FormMessage name="description" />
            </FormItem>
        </Field>
    </div>
</template>
