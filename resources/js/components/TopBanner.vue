<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { HoverCard, HoverCardContent, HoverCardTrigger } from '@/components/ui/hover-card';
import { router, usePage } from '@inertiajs/vue3';
import { CreditCard, MapPin, PlusCircle } from 'lucide-vue-next';
import { computed } from 'vue';

interface Address {
    street: string;
    number: string;
    city: string;
}

interface CreditCard {
    card_last4: string;
}

defineProps<{
    address: Address | null;
    creditCard: CreditCard | null;
}>();

const page = usePage();
const isLoggedIn = computed(() => !!(page.props.auth as any).user);

const formatAddress = (address: string): string => {
    if (address && address.length > 15) {
        return address.substring(0, 15) + '...';
    }
    return address || '';
};

const goToRegisterCard = () => {
    router.visit(route('cards.create'));
};

const goToRegisterAddress = () => {
    router.visit(route('addresses.create'));
};
</script>

<template>
    <div v-if="isLoggedIn" class="bg-primary text-primary-foreground w-full py-4">
        <div class="mx-auto flex max-w-[1200px] items-center justify-end px-4 text-sm font-medium lg:max-w-6xl">
            <!-- Layout para mobile -->
            <div class="flex space-x-2 sm:hidden">
                <div v-if="creditCard">
                    <HoverCard>
                        <HoverCardTrigger>
                            <button class="bg-primary-foreground/10 flex items-center space-x-1 rounded-md px-3 py-1">
                                <CreditCard class="mr-1 h-4 w-4" />
                                <span class="text-xs">Card</span>
                            </button>
                        </HoverCardTrigger>
                        <HoverCardContent class="w-64">
                            <span class="flex items-center gap-2">
                                <CreditCard class="h-4 w-4" />
                                •••• •••• •••• {{ creditCard.card_last4 }}
                            </span>
                        </HoverCardContent>
                    </HoverCard>
                </div>
                <Button v-else @click="goToRegisterCard" variant="secondary" size="sm" class="h-auto py-1">
                    <PlusCircle class="mr-1 h-3 w-3" /> Card
                </Button>

                <div v-if="address">
                    <HoverCard>
                        <HoverCardTrigger>
                            <button class="bg-primary-foreground/10 flex items-center space-x-1 rounded-md px-3 py-1">
                                <MapPin class="mr-1 h-4 w-4" />
                                <span class="text-xs">Address</span>
                            </button>
                        </HoverCardTrigger>
                        <HoverCardContent class="w-64">
                            <span class="flex items-center gap-2">
                                <MapPin class="h-4 w-4" />
                                {{ formatAddress(address.street) }}, {{ address.number }}
                            </span>
                        </HoverCardContent>
                    </HoverCard>
                </div>
                <Button v-else @click="goToRegisterAddress" variant="secondary" size="sm" class="h-auto py-1">
                    <PlusCircle class="mr-1 h-3 w-3" /> Address
                </Button>
            </div>

            <!-- Layout para desktop -->
            <div class="hidden items-center space-x-6 sm:flex">
                <div v-if="creditCard" class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Credit Card</span>
                    <span class="flex items-center gap-2">
                        <CreditCard class="h-4 w-4" />
                        •••• •••• •••• {{ creditCard.card_last4 }}
                    </span>
                </div>
                <Button v-else @click="goToRegisterCard" variant="secondary" size="sm">
                    <PlusCircle class="mr-2 h-4 w-4" />
                    Register Card
                </Button>

                <div v-if="address" class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Shipping Address</span>
                    <span class="flex items-center gap-2">
                        <MapPin class="h-4 w-4" />
                        {{ formatAddress(address.street) }}, {{ address.number }} - {{ address.city }}
                    </span>
                </div>
                <Button v-else @click="goToRegisterAddress" variant="secondary" size="sm">
                    <PlusCircle class="mr-2 h-4 w-4" />
                    Register Address
                </Button>
            </div>
        </div>
    </div>
</template>
