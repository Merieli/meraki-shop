<script setup lang="ts">
import ProductForm from '@/components/products/ProductForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { apiService } from '@/utils/api';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Register Product',
        href: '/products/create',
    },
];

interface ProductApiData {
    name: string;
    price: number; // In cents (integer)
    cost_price: number | null; // In cents (integer), optional
    stock: number | null; // optional
    thumbnail: string;
    images: string | null; // optional
    short_description: string;
    description: string | null; // optional
    rating: number;
    sku: string | null; // optional
}

const isSubmitting = ref(false);
const error = ref<string | null>(null);
const success = ref<string | null>(null);
const formKey = ref(0); // Chave para forçar recriação do componente

// Função para resetar o formulário
const resetForm = () => {
    formKey.value++; // Incrementa a chave para forçar a recriação do componente
};

const handleSubmit = async (formData: ProductApiData) => {
    // Limpar mensagens anteriores
    error.value = null;
    success.value = null;
    isSubmitting.value = true;

    console.log('Dados a serem enviados:', formData);

    try {
        // Garantir que os dados estão no formato correto para a API
        const payload = {
            name: formData.name.trim(),
            price: Number(formData.price),
            cost_price: formData.cost_price !== null ? Number(formData.cost_price) : null,
            stock: formData.stock !== null ? Number(formData.stock) : null,
            thumbnail: formData.thumbnail.trim(),
            images: formData.images || null,
            short_description: formData.short_description.trim(),
            description: formData.description || null,
            rating: Number(formData.rating),
            sku: formData.sku || null,
        };

        console.log('Payload formatado:', payload);

        // Usar o serviço de API em vez do Inertia
        const response = await apiService.create('products', payload);
        console.log('Resposta da API:', response);

        success.value = 'Produto criado com sucesso! Você pode criar outro produto se desejar.';

        // Resetar o formulário para um novo produto
        resetForm();

        // Mostrar alerta de sucesso sem redirecionamento
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (err: any) {
        console.error('Erro na requisição:', err);

        // Mostrar mensagem de erro específica se disponível na resposta
        if (err.response && err.response.data && err.response.data.message) {
            error.value = `Falha ao criar o produto: ${err.response.data.message}`;
        } else {
            error.value = 'Falha ao criar o produto. Verifique os dados e tente novamente.';
        }

        // Mostrar erros de validação se houver
        if (err.response && err.response.data && err.response.data.errors) {
            console.error('Erros de validação:', err.response.data.errors);

            // Mostrar o primeiro erro de validação na mensagem de erro
            const firstError = Object.values(err.response.data.errors)[0];
            if (firstError && Array.isArray(firstError) && firstError.length > 0) {
                error.value = `Falha ao criar o produto: ${firstError[0]}`;
            }
        }

        // Rolar para o topo para mostrar o erro
        window.scrollTo({ top: 0, behavior: 'smooth' });
    } finally {
        isSubmitting.value = false;
    }
};

const handleCancel = () => {
    router.visit('/products');
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Create Product" />

        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Create Product</h2>
                <p class="text-muted-foreground">Fill in the information below to create a new product</p>
            </div>

            <!-- Mensagens de erro/sucesso -->
            <div v-if="error" class="bg-destructive/15 text-destructive rounded-md p-4">
                {{ error }}
            </div>
            <div v-if="success" class="flex items-center rounded-md bg-green-500/15 p-4 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    />
                </svg>
                {{ success }}
            </div>

            <div class="flex flex-col space-y-8 lg:flex-row lg:space-y-0 lg:space-x-12">
                <div class="flex-1 lg:max-w-3xl">
                    <ProductForm
                        :key="formKey"
                        submit-endpoint="/api/products"
                        @submit="handleSubmit"
                        @cancel="handleCancel"
                        :disabled="isSubmitting"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
