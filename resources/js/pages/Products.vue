<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import CustomerTestimonials from '@/components/CustomerTestimonials.vue';
import ProductCard from '@/components/ProductCard.vue';
import TopBanner from '@/components/TopBanner.vue';
import { fromCents } from '@/utils/money';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, ref } from 'vue';

const isLoggedIn = computed(() => {
    // @ts-ignore - Acessando a propriedade dinamicamente
    return !!usePage().props.auth && !!usePage().props.auth.user;
});

interface Product {
    id: number;
    name: string;
    price: number;
    category: string;
    image: string;
    inStock: boolean;
}

interface ApiProduct {
    id: number;
    name: string;
    price: string | number;
    category?: string;
    image?: string;
    in_stock?: boolean;
    inStock?: boolean;
    [key: string]: any; // Para quaisquer outras propriedades que possam existir
}

const products = ref<Product[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const fetchProducts = async () => {
    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get('/api/products');

        if (response.data && Array.isArray(response.data.data)) {
            products.value = response.data.data.map((item: ApiProduct) => ({
                id: item.id,
                name: item.name,
                price: fromCents(Number(item.price)),
                category: item.category || 'Uncategorized',
                image: item.image || 'https://via.placeholder.com/150',
                inStock: item.in_stock || item.inStock || true,
            }));
        } else {
            throw new Error('Unexpected API response format');
        }
    } catch (err) {
        console.error('Error fetching products:', err);
        error.value = 'Failed to load products. Please try again later.';
        if (import.meta.env.DEV) {
            products.value = [
                {
                    id: 1,
                    name: 'Pro Sports Sneakers',
                    price: 299.9,
                    category: 'Footwear',
                    image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                    inStock: true,
                },
                {
                    id: 2,
                    name: 'Basic T-Shirt',
                    price: 79.9,
                    category: 'Clothing',
                    image: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
                    inStock: true,
                },
                {
                    id: 3,
                    name: 'Smart Watch',
                    price: 499.9,
                    category: 'Accessories',
                    image: 'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
                    inStock: true,
                },
            ];
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchProducts();
});
</script>

<template>
    <Head title="Collectibles & Rare Action Figures">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div v-if="isLoggedIn" class="fixed top-0 left-0 z-50 w-full">
        <TopBanner cardLastDigits="2345" addressRaw="Pennsylvania" addressNumber="1500" addressCity="San Francisco" />
    </div>

    <div
        :class="[
            'flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]',
            isLoggedIn ? 'pt-20 lg:pt-24' : 'pt-6 lg:pt-8',
        ]"
    >
        <AppHeader />
        <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
            <main class="flex w-full max-w-[1200px] flex-col overflow-hidden rounded-lg lg:max-w-6xl">
                <div class="mb-12 text-left">
                    <h2 class="mb-3 text-3xl font-bold text-[#1b1b18] dark:text-white">Rare Collectibles & Action Figures</h2>
                    <p class="max-w-2xl text-[#555] dark:text-gray-300">
                        Exclusive, limited-edition collectibles for serious enthusiasts. Each item is authenticated and available for one-per-customer
                        purchase only. Secure your rare piece today before they're gone forever.
                    </p>
                </div>

                <!-- Loading State -->
                <div v-if="loading" class="flex flex-col items-center justify-center py-12">
                    <div
                        class="h-12 w-12 animate-spin rounded-full border-4 border-[#1b1b18] border-t-transparent dark:border-white dark:border-t-transparent"
                    ></div>
                    <p class="mt-4 text-[#555] dark:text-gray-300">Loading products...</p>
                </div>

                <!-- Error State -->
                <div v-else-if="error" class="rounded-lg bg-red-50 p-6 text-center dark:bg-red-900/20">
                    <p class="text-red-600 dark:text-red-400">{{ error }}</p>
                    <button
                        @click="fetchProducts"
                        class="mt-4 rounded-md bg-[#1b1b18] px-4 py-2 text-white hover:bg-[#333] dark:bg-[#f0f0f0] dark:text-[#1b1b18] dark:hover:bg-white"
                    >
                        Try Again
                    </button>
                </div>

                <!-- Products Grid -->
                <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <template v-if="products.length > 0">
                        <ProductCard v-for="product in products" :key="product.id" :product="product" />
                    </template>
                    <template v-else>
                        <div class="col-span-full rounded-lg bg-gray-50 p-6 text-center dark:bg-gray-800/20">
                            <p class="text-[#555] dark:text-gray-300">No products found.</p>
                        </div>
                    </template>
                </div>

                <CustomerTestimonials />
            </main>
        </div>
    </div>

    <AppFooter />
</template>
