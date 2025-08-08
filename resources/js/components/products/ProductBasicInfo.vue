<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import type { FormErrors } from '@/utils/formValidation';
import { computed } from 'vue';

interface Props {
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();

const name = defineModel<string>('name', { required: true });
const description = defineModel<string>('description', { required: true });
const short_description = defineModel<string>('short_description', { required: true });

// Computed properties para determinar o estado de cada campo
const nameStatus = computed(() => {
    if (!name.value) return 'default';
    return props.errors.name ? 'error' : 'success';
});

const shortDescriptionStatus = computed(() => {
    if (!short_description.value) return 'default';
    return props.errors.short_description ? 'error' : 'success';
});

const descriptionStatus = computed(() => {
    if (!description.value) return 'default';
    return props.errors.description ? 'error' : 'success';
});

// Funções para validação em tempo real
const validateNameField = (value: string) => {
    props.validateField('name', value);
};

const validateShortDescriptionField = (value: string) => {
    props.validateField('short_description', value);
};

const validateDescriptionField = (value: string) => {
    props.validateField('description', value);
};

// Classes dinâmicas para os inputs baseadas no estado
const getInputClasses = (status: string) => {
    const baseClasses = 'transition-colors duration-200';
    switch (status) {
        case 'error':
            return `${baseClasses} border-red-500 focus:border-red-500 focus:ring-red-500`;
        case 'success':
            return `${baseClasses} border-green-500 focus:border-green-500 focus:ring-green-500`;
        default:
            return baseClasses;
    }
};
</script>

<template>
    <div class="space-y-4">
        <!-- Name -->
        <FormField name="name">
            <FormItem>
                <FormLabel>Name</FormLabel>
                <FormControl>
                    <Input
                        v-model="name"
                        @input="validateNameField(name)"
                        @blur="validateNameField(name)"
                        placeholder="Nome do produto"
                        :class="getInputClasses(nameStatus)"
                    />
                </FormControl>
                <FormDescription>This is the name that will be displayed for your product.</FormDescription>
                <FormMessage v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Short Description -->
        <FormField name="short_description">
            <FormItem>
                <FormLabel>Short Description</FormLabel>
                <FormControl>
                    <Input
                        v-model="short_description"
                        @input="validateShortDescriptionField(short_description)"
                        @blur="validateShortDescriptionField(short_description)"
                        placeholder="Brief product description"
                        :class="getInputClasses(shortDescriptionStatus)"
                    />
                </FormControl>
                <FormDescription>A short description that will be displayed on product cards.</FormDescription>
                <FormMessage v-if="errors.short_description" class="mt-1 text-sm text-red-500">{{ errors.short_description }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Full Description -->
        <FormField name="description">
            <FormItem>
                <FormLabel>Full Description</FormLabel>
                <FormControl>
                    <Textarea
                        v-model="description"
                        @input="validateDescriptionField(description)"
                        @blur="validateDescriptionField(description)"
                        placeholder="Detailed product description"
                        :class="`min-h-[100px] ${getInputClasses(descriptionStatus)}`"
                    />
                </FormControl>
                <FormDescription>Provide a detailed description of your product.</FormDescription>
                <FormMessage v-if="errors.description" class="mt-1 text-sm text-red-500">{{ errors.description }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
