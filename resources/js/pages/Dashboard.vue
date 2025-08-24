<script setup lang="ts">
import RecentOrdersTable from '@/components/dashboard/RecentOrdersTable.vue';
import SalesCard from '@/components/dashboard/SalesCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { apiService } from '@/utils/api';
import { Head } from '@inertiajs/vue3';
import { DollarSign, ShoppingBag, TrendingUp } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

type OrderStatus = 'completed' | 'processing' | 'pending' | 'cancelled';
interface TableOrder {
    id: number;
    customer_name: string;
    date: string;
    amount: number;
    status: OrderStatus;
}

interface ApiOrderItem {
    id: number;
    quantity: number;
    unit_price: number;
}

interface ApiOrder {
    id: number;
    status: OrderStatus;
    created_at: string;
    user: { name: string };
    order_items: ApiOrderItem[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const totalRevenue = ref(0);
const totalOrders = ref(0);
const totalProfit = ref(0);
const recentOrders = ref<TableOrder[]>([]);
const isLoading = ref(true);
const error = ref<string | null>(null);

const fetchRecentOrders = async () => {
    isLoading.value = true;
    error.value = null;
    try {
        const ordersFromApi = await apiService.list<ApiOrder[]>('orders', { scope: 'all' }, true);

        totalOrders.value = ordersFromApi.length;

        let revenue = 0;
        ordersFromApi.forEach((order) => {
            const orderTotal = order.order_items.reduce((total, item) => total + item.unit_price * item.quantity, 0);
            revenue += orderTotal;
        });

        totalRevenue.value = revenue;
        const profit = 0.3;
        totalProfit.value = Math.round(revenue * profit);

        recentOrders.value = ordersFromApi
            .map((order) => ({
                id: order.id,
                customer_name: order.user.name,
                date: order.created_at,
                amount: order.order_items.reduce((total, item) => total + item.unit_price * item.quantity, 0),
                status: order.status,
            }))
            .slice(0, 5); // Limit to 5 most recent orders for display
    } catch (err) {
        error.value = 'Could not load recent orders. Please try again later.';
        console.error(err);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    fetchRecentOrders();
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Sales Dashboard</h2>
                <p class="text-muted-foreground">Overview of your store's performance</p>
            </div>

            <div v-if="isLoading" class="flex h-[400px] items-center justify-center">
                <div class="border-primary h-12 w-12 animate-spin rounded-full border-4 border-t-transparent"></div>
            </div>

            <div v-else-if="error" class="rounded-md border border-red-200 bg-red-50 p-4 text-red-700">
                <h4 class="font-bold">Error</h4>
                <p>{{ error }}</p>
            </div>

            <div v-else class="space-y-6">
                <!-- Stats cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <SalesCard title="Total Revenue" :value="totalRevenue" :percent-change="12.5" :icon="DollarSign" :currency="true" />
                    <SalesCard title="Total Orders" :value="totalOrders" :percent-change="8.2" :icon="ShoppingBag" />
                    <SalesCard title="Total Profit" :value="totalProfit" :percent-change="-2.4" :icon="TrendingUp" :currency="true" />
                </div>

                <!-- Charts and tables -->
                <RecentOrdersTable :orders="recentOrders" />
            </div>
        </div>
    </AppLayout>
</template>
