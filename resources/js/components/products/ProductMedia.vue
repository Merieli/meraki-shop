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

const thumbnail = defineModel<string>('thumbnail', { required: true });
const images = defineModel<string>('images', { required: true });
const rating = defineModel<number>('rating', { required: true });

// Computed properties para determinar o estado de cada campo
const thumbnailStatus = computed(() => {
    if (!thumbnail.value) return 'default';
    return props.errors.thumbnail ? 'error' : 'success';
});

const imagesStatus = computed(() => {
    if (!images.value) return 'default';
    return props.errors.images ? 'error' : 'success';
});

const ratingStatus = computed(() => {
    if (rating.value === undefined || rating.value === null) return 'default';
    return props.errors.rating ? 'error' : 'success';
});

// Funções para validação em tempo real
const validateThumbnailField = (value: string) => {
    props.validateField('thumbnail', value);
};

const validateImagesField = (value: string) => {
    props.validateField('images', value);
};

const validateRatingField = (value: any) => {
    const numValue = Number(value);
    props.validateField('rating', numValue);
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
        <!-- Thumbnail -->
        <FormField name="thumbnail">
            <FormItem>
                <FormLabel>Thumbnail</FormLabel>
                <FormControl>
                    <Input
                        v-model="thumbnail"
                        @input="validateThumbnailField(thumbnail)"
                        @blur="validateThumbnailField(thumbnail)"
                        placeholder="Main image URL"
                        :class="getInputClasses(thumbnailStatus)"
                    />
                </FormControl>
                <FormDescription>URL of the main product image.</FormDescription>
                <FormMessage v-if="errors.thumbnail" class="mt-1 text-sm text-red-500">{{ errors.thumbnail }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Images -->
        <FormField name="images">
            <FormItem>
                <FormLabel>Images</FormLabel>
                <FormControl>
                    <Textarea
                        v-model="images"
                        @input="validateImagesField(images)"
                        @blur="validateImagesField(images)"
                        placeholder="Additional image URLs separated by comma"
                        :class="`min-h-[80px] ${getInputClasses(imagesStatus)}`"
                    />
                </FormControl>
                <FormDescription>Additional image URLs separated by comma.</FormDescription>
                <FormMessage v-if="errors.images" class="mt-1 text-sm text-red-500">{{ errors.images }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Rating -->
        <FormField name="rating">
            <FormItem>
                <FormLabel>Rating</FormLabel>
                <FormControl>
                    <Input
                        v-model="rating"
                        @input="validateRatingField(rating)"
                        @blur="validateRatingField(rating)"
                        type="number"
                        min="1"
                        max="5"
                        step="1"
                        placeholder="1"
                        :class="getInputClasses(ratingStatus)"
                    />
                </FormControl>
                <FormDescription>Set the initial rating for the product (1-5).</FormDescription>
                <FormMessage v-if="errors.rating" class="mt-1 text-sm text-red-500">{{ errors.rating }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
