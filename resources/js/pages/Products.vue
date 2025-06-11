<script setup lang="ts">
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';
import CustomerTestimonials from '@/components/CustomerTestimonials.vue';
import ProductCard from '@/components/ProductCard.vue';
import TopBanner from '@/components/TopBanner.vue';
import { useTopBannerData } from '@/composables/useTopBannerData';
import { ApiProduct, Product } from '@/types/product';
import { apiService } from '@/utils/api';
import { fromCents } from '@/utils/money';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

const page = usePage<{ auth?: { user: any } }>();
const isLoggedIn = computed(() => !!page.props.auth?.user);

const products = ref<Product[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const { address, creditCard, fetchTopBannerData } = useTopBannerData();

const fetchProducts = async () => {
    loading.value = true;
    error.value = null;

    try {
        const response = await apiService.list<{ data: ApiProduct[] }>('products');

        if (response && Array.isArray(response.data)) {
            products.value = response.data.map((item: ApiProduct) => ({
                id: item.id,
                name: item.name,
                price: fromCents(Number(item.price)),
                shortDescription: item.short_description || '',
                thumbnail: item.thumbnail || 'https://via.placeholder.com/150',
                inStock: !!item.stock && item.stock > 0,
                rating: item.rating || 0,
            }));
        } else {
            throw new Error('Unexpected API response format');
        }
    } catch (err) {
        console.error('Error fetching products:', err);
        error.value = 'Failed to load products. Please try again later.';
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchProducts();
    fetchTopBannerData();
});
</script>

<template>
    <Head title="Collectibles & Rare Action Figures">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div v-if="isLoggedIn" class="fixed top-0 left-0 z-50 w-full">
        <TopBanner :address="address" :credit-card="creditCard" />
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
