<script setup lang="ts">
import { FormControl, FormItem, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Field } from 'vee-validate';
import { Label } from '../ui/label';
</script>

<template>
    <div class="space-y-4">
        <Field name="thumbnail" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label for="thumbnail">Thumbnail</Label>
                <FormControl>
                    <Input v-model="field.value" @change="handleChange" @blur="handleBlur" placeholder="https://placeholder.com/300x200" />
                </FormControl>
            </FormItem>
            <FormMessage name="thumbnail" />
        </Field>

        <Field name="images" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Images</Label>
                <FormControl>
                    <Textarea
                        v-model="field.value"
                        @change="handleChange"
                        @blur="handleBlur"
                        placeholder="Additional image URLs separated by comma"
                    />
                </FormControl>
            </FormItem>
            <FormMessage name="images" />
        </Field>

        <Field name="rating" v-slot="{ field, handleChange, handleBlur }">
            <FormItem>
                <Label>Rating</Label>
                <FormControl>
                    <Input v-model="field.value" @change="handleChange" @blur="handleBlur" type="number" min="1" max="5" step="1" placeholder="1" />
                </FormControl>
            </FormItem>
            <FormMessage name="rating" />
        </Field>
    </div>
</template>
