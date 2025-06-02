<script setup lang="ts">
import RecentOrdersTable from '@/components/dashboard/RecentOrdersTable.vue';
import SalesCard from '@/components/dashboard/SalesCard.vue';
import SalesChart from '@/components/dashboard/SalesChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { DollarSign, ShoppingBag, TrendingUp, Users } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Sales stats
const totalRevenue = ref(12845000); // $128,450.00
const totalOrders = ref(432);
const totalCustomers = ref(189);
const totalProfit = ref(5432000); // $54,320.00

// Weekly sales data
const weeklySalesData = ref([
    { date: '2023-10-01', sales: 5200000 },
    { date: '2023-10-02', sales: 4800000 },
    { date: '2023-10-03', sales: 6500000 },
    { date: '2023-10-04', sales: 4900000 },
    { date: '2023-10-05', sales: 7200000 },
    { date: '2023-10-06', sales: 8500000 },
    { date: '2023-10-07', sales: 6800000 },
]);

// Recent orders with proper type for status
type OrderStatus = 'completed' | 'processing' | 'pending' | 'cancelled';

const recentOrders = ref([
    { id: 1001, customer_name: 'John Smith', date: '2023-10-07T14:30:00Z', amount: 12999, status: 'completed' as OrderStatus },
    { id: 1002, customer_name: 'Emily Johnson', date: '2023-10-06T09:15:00Z', amount: 24500, status: 'processing' as OrderStatus },
    { id: 1003, customer_name: 'Michael Brown', date: '2023-10-05T16:45:00Z', amount: 8999, status: 'pending' as OrderStatus },
    { id: 1004, customer_name: 'Sarah Wilson', date: '2023-10-04T11:20:00Z', amount: 34990, status: 'completed' as OrderStatus },
    { id: 1005, customer_name: 'David Lee', date: '2023-10-03T08:00:00Z', amount: 5499, status: 'cancelled' as OrderStatus },
]);

// This would typically load data from an API
const isLoading = ref(true);

onMounted(() => {
    // Simulate API call
    setTimeout(() => {
        isLoading.value = false;
    }, 500);
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6 pb-16">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">Sales Dashboard</h2>
                <p class="text-muted-foreground">Overview of your store's performance for the last week</p>
            </div>

            <div v-if="isLoading" class="flex h-[400px] items-center justify-center">
                <div class="border-primary h-12 w-12 animate-spin rounded-full border-4 border-t-transparent"></div>
            </div>

            <div v-else class="space-y-6">
                <!-- Stats cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <SalesCard title="Total Revenue" :value="totalRevenue" :percent-change="12.5" :icon="DollarSign" :currency="true" />
                    <SalesCard title="Total Orders" :value="totalOrders" :percent-change="8.2" :icon="ShoppingBag" />
                    <SalesCard title="Total Customers" :value="totalCustomers" :percent-change="5.1" :icon="Users" />
                    <SalesCard title="Total Profit" :value="totalProfit" :percent-change="-2.4" :icon="TrendingUp" :currency="true" />
                </div>

                <!-- Charts and tables -->
                <div class="grid gap-6 md:grid-cols-2">
                    <SalesChart title="Weekly Sales" :data="weeklySalesData" />
                    <RecentOrdersTable :orders="recentOrders" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
