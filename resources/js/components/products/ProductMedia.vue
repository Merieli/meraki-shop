<script setup lang="ts">
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import type { FormErrors } from '@/utils/formValidation';

interface Props {
    formData: {
        thumbnail: string;
        images: string;
        rating: number;
    };
    errors: FormErrors;
    validateField: (field: string, value: any) => boolean;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="space-y-4">
        <!-- Thumbnail -->
        <FormField name="thumbnail">
            <FormItem>
                <FormLabel>Thumbnail</FormLabel>
                <FormControl>
                    <Input v-model="formData.thumbnail" @blur="validateField('thumbnail', formData.thumbnail)" placeholder="Main image URL" />
                </FormControl>
                <FormDescription>URL of the main product image.</FormDescription>
                <FormMessage v-if="errors.thumbnail">{{ errors.thumbnail }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Images -->
        <FormField name="images">
            <FormItem>
                <FormLabel>Images</FormLabel>
                <FormControl>
                    <Textarea
                        v-model="formData.images"
                        @blur="validateField('images', formData.images)"
                        placeholder="Additional image URLs separated by comma"
                        class="min-h-[80px]"
                    />
                </FormControl>
                <FormDescription>Additional image URLs separated by comma.</FormDescription>
                <FormMessage v-if="errors.images">{{ errors.images }}</FormMessage>
            </FormItem>
        </FormField>

        <!-- Rating -->
        <FormField name="rating">
            <FormItem>
                <FormLabel>Rating</FormLabel>
                <FormControl>
                    <Input
                        v-model="formData.rating"
                        @blur="validateField('rating', formData.rating)"
                        type="number"
                        min="0"
                        max="5"
                        step="1"
                        placeholder="0"
                    />
                </FormControl>
                <FormDescription>Set the initial rating for the product (0-5).</FormDescription>
                <FormMessage v-if="errors.rating">{{ errors.rating }}</FormMessage>
            </FormItem>
        </FormField>
    </div>
</template>
