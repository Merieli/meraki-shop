<script setup lang="ts">
import { formatDate } from '@/utils/formatters';
import { formatCurrency } from '@/utils/money';

interface OrderItem {
    id: number;
    customer_name: string;
    date: string;
    amount: number;
    status: 'completed' | 'processing' | 'pending' | 'cancelled';
}

interface Props {
    orders: OrderItem[];
}

defineProps<Props>();

const getStatusClass = (status: string): string => {
    switch (status) {
        case 'completed':
            return 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400';
        case 'processing':
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400';
        case 'cancelled':
            return 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400';
        default:
            return '';
    }
};

const getStatusText = (status: string): string => {
    return status.charAt(0).toUpperCase() + status.slice(1);
};
</script>

<template>
    <div class="bg-card rounded-xl border p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-medium">Recent Orders</h3>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-muted-foreground border-b text-left text-sm">
                        <th class="pb-2">Order</th>
                        <th class="pb-2">Customer</th>
                        <th class="pb-2">Date</th>
                        <th class="pb-2">Amount</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id" class="border-b last:border-b-0">
                        <td class="py-3">#{{ order.id }}</td>
                        <td class="py-3">{{ order.customer_name }}</td>
                        <td class="py-3">{{ formatDate(order.date) }}</td>
                        <td class="py-3">{{ formatCurrency(order.amount, 'USD', true) }}</td>
                        <td class="py-3">
                            <span
                                :class="getStatusClass(order.status)"
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                            >
                                {{ getStatusText(order.status) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
