<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

import { Button } from '@/components/ui/button';
import {
Form,
FormControl,
FormDescription,
FormField,
FormItem,
FormLabel,
FormMessage,
} from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import {
Select,
SelectContent,
SelectItem,
SelectTrigger,
SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';

import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import * as z from 'zod';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Product',
        href: '/products/create',
    },
];

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2, {
    message: 'Name must be at least 2 characters.',
  }),
  description: z.string().min(10, {
    message: 'Description must be at least 10 characters.',
  }),
  price: z.string().regex(/^\d+(\.\d{1,2})?$/, {
    message: 'Please enter a valid price.',
  }),
  status: z.enum(['draft', 'published']),
}));

const { handleSubmit, isSubmitting } = useForm({
  validationSchema: formSchema,
  initialValues: {
    name: '',
    description: '',
    price: '',
    status: 'draft',
  },
});

const onSubmit = handleSubmit((values) => {
  router.post('/api/products', values);
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Create Product" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Create Product</h2>
                <p class="text-muted-foreground">
                    Fill in the information below to create a new product
                </p>
            </div>

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-x-12 lg:space-y-0">
                <div class="flex-1 lg:max-w-2xl">
                    <Form @submit="onSubmit">
                        <div class="space-y-4">
                            <FormField
                                v-slot="{ componentField }"
                                name="name"
                                label="Name"
                            >
                                <FormItem>
                                    <FormLabel>Name</FormLabel>
                                    <FormControl>
                                        <Input v-bind="componentField" placeholder="Enter product name" />
                                    </FormControl>
                                    <FormDescription>
                                        This is the name that will be displayed for your product.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            </FormField>

                            <FormField
                                v-slot="{ componentField }"
                                name="description"
                                label="Description"
                            >
                                <FormItem>
                                    <FormLabel>Description</FormLabel>
                                    <FormControl>
                                        <Textarea
                                            v-bind="componentField"
                                            placeholder="Enter product description"
                                            class="min-h-[100px]"
                                        />
                                    </FormControl>
                                    <FormDescription>
                                        Provide a detailed description of your product.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            </FormField>

                            <FormField
                                v-slot="{ componentField }"
                                name="price"
                                label="Price"
                            >
                                <FormItem>
                                    <FormLabel>Price</FormLabel>
                                    <FormControl>
                                        <Input
                                            v-bind="componentField"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                        />
                                    </FormControl>
                                    <FormDescription>
                                        Set the price for your product.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            </FormField>

                            <FormField
                                v-slot="{ componentField }"
                                name="stock"
                                label="Stock"
                            >
                                <FormItem>
                                    <FormLabel>Stock</FormLabel>
                                    <FormControl>
                                        <Input
                                            v-bind="componentField"
                                            type="number"
                                            step="100"
                                            min="1"
                                            placeholder="0"
                                        />
                                    </FormControl>
                                    <FormDescription>
                                        Set the stock for your product.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            </FormField>

                            <FormField
                                v-slot="{ value, handleChange }"
                                name="status"
                                label="Status"
                            >
                                <FormItem>
                                    <FormLabel>Status</FormLabel>
                                    <Select :value="value" @update:value="handleChange">
                                        <FormControl>
                                            <SelectTrigger>
                                                <SelectValue placeholder="Select a status" />
                                            </SelectTrigger>
                                        </FormControl>
                                        <SelectContent>
                                            <SelectItem value="draft">Draft</SelectItem>
                                            <SelectItem value="published">Published</SelectItem>
                                        </SelectContent>
                                    </Select>
                                    <FormDescription>
                                        Choose whether to publish the product or save as draft.
                                    </FormDescription>
                                    <FormMessage />
                                </FormItem>
                            </FormField>

                            <div class="flex justify-end">
                                <Button type="submit" :disabled="isSubmitting">
                                    {{ 'Create Product' }}
                                </Button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
