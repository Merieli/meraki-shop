<script setup lang="ts">
import { formatCurrency } from '@/utils/money';

interface Props {
    title: string;
    value: number;
    percentChange: number;
    icon?: any;
    currency?: boolean;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="bg-card rounded-xl border p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h3 class="text-muted-foreground text-sm font-medium">{{ title }}</h3>
            <component :is="icon" v-if="icon" class="text-muted-foreground h-4 w-4" />
        </div>
        <div class="mt-2 text-2xl font-bold">
            {{ currency ? formatCurrency(value, 'USD', true) : value }}
        </div>
        <div class="mt-1" :class="percentChange >= 0 ? 'text-green-600' : 'text-red-600'">
            <span>{{ percentChange >= 0 ? '+' : '' }}{{ percentChange }}%</span>
            <span class="text-muted-foreground text-xs"> from last week</span>
        </div>
    </div>
</template>
