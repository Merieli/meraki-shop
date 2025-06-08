<script setup lang="ts">
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { usePage } from '@inertiajs/vue3';
import { CreditCard, MapPin } from 'lucide-vue-next';
import { computed } from 'vue';

withDefaults(
    defineProps<{
        cardLastDigits?: string;
        addressRaw?: string;
        addressNumber?: string;
        addressCity?: string;
    }>(),
    {
        cardLastDigits: '4567',
        addressRaw: 'Main Street',
        addressNumber: '123',
        addressCity: 'New York',
    },
);

const statePage = usePage();
const isLoggedIn = computed(() => {
    return !!statePage.props.auth && Object.hasOwn(statePage.props.auth, 'user') && (statePage.props.auth as any).user !== null;
});

const formatAddress = (address: string): string => {
    if (address.length > 3) {
        return address.substring(0, 3) + '...';
    }
    return address;
};
</script>

<template>
    <div v-if="isLoggedIn" class="bg-primary text-primary-foreground w-full py-4">
        <div class="mx-auto flex max-w-[1200px] items-center justify-end px-4 text-sm font-medium lg:max-w-6xl">
            <!-- Layout para mobile - dois hover cards separados -->
            <div class="flex space-x-2 sm:hidden">
                <!-- Hover Card para Cartão de Crédito -->
                <HoverCard>
                    <HoverCardTrigger>
                        <button class="bg-primary-foreground/10 flex items-center space-x-1 rounded-md px-3 py-1">
                            <CreditCard class="mr-1 h-4 w-4" />
                            <span class="text-xs">Card</span>
                        </button>
                    </HoverCardTrigger>
                    <HoverCardContent class="w-64">
                        <div class="flex flex-col">
                            <span class="text-xs uppercase opacity-80">Credit Card</span>
                            <span class="flex items-center gap-2">
                                <CreditCard class="h-4 w-4" />
                                •••• •••• •••• {{ cardLastDigits }}
                            </span>
                        </div>
                    </HoverCardContent>
                </HoverCard>

                <!-- Hover Card para Endereço -->
                <HoverCard>
                    <HoverCardTrigger>
                        <button class="bg-primary-foreground/10 flex items-center space-x-1 rounded-md px-3 py-1">
                            <MapPin class="mr-1 h-4 w-4" />
                            <span class="text-xs">Address</span>
                        </button>
                    </HoverCardTrigger>
                    <HoverCardContent class="w-64">
                        <div class="flex flex-col">
                            <span class="text-xs uppercase opacity-80">Shipping Address</span>
                            <span class="flex items-center gap-2">
                                <MapPin class="h-4 w-4" />
                                {{ formatAddress(addressRaw) }}, {{ addressNumber }} - {{ addressCity }}
                            </span>
                        </div>
                    </HoverCardContent>
                </HoverCard>
            </div>

            <!-- Layout para desktop -->
            <div class="hidden items-center space-x-6 sm:flex">
                <div class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Credit Card</span>
                    <span class="flex items-center gap-2">
                        <CreditCard class="h-4 w-4" />
                        •••• •••• •••• {{ cardLastDigits }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Shipping Address</span>
                    <span class="flex items-center gap-2">
                        <MapPin class="h-4 w-4" />
                        {{ formatAddress(addressRaw) }}, {{ addressNumber }} - {{ addressCity }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
