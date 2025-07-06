<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import type { FormErrors } from '@/utils/formValidation';

interface Props {
    formData: {
        name: string;
        short_description: string;
        description: string;
    };
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

defineProps<Props>();
</script>

<template>
    <div class="space-y-4">
        <!-- Product Name -->
        <FormField name="name">
            <FormItem>
                <FormLabel>Name</FormLabel>
                <FormControl>
                    <Input v-model="formData.name" @blur="validateField('name', formData.name)" placeholder="Enter product name" />
                </FormControl>
                <FormDescription>This is the name that will be displayed for your product.</FormDescription>
                <FormMessage v-if="errors.name">{{ errors.name }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Short Description -->
        <FormField name="short_description">
            <FormItem>
                <FormLabel>Short Description</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.short_description"
                        @blur="validateField('short_description', formData.short_description)"
                        placeholder="Brief product description"
                    />
                </FormControl>
                <FormDescription>A short description that will be displayed on product cards.</FormDescription>
                <FormMessage v-if="errors.short_description">{{ errors.short_description }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Full Description -->
        <FormField name="description">
            <FormItem>
                <FormLabel>Full Description</FormLabel>
                <FormControl>
                    <Textarea
                        v-model="formData.description"
                        @blur="validateField('description', formData.description)"
                        placeholder="Detailed product description"
                        class="min-h-[100px]"
                    />
                </FormControl>
                <FormDescription>Provide a detailed description of your product.</FormDescription>
                <FormMessage v-if="errors.description">{{ errors.description }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
