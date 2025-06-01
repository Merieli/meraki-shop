<script setup lang="ts">
withDefaults(
    defineProps<{
        cardLastDigits?: string;
        addressSummary?: string;
    }>(),
    {
        cardLastDigits: '4567',
        addressSummary: 'Rua *********, 123 - São Paulo, SP',
    },
);
</script>

<template>
    <div class="bg-primary text-primary-foreground w-full py-4">
        <div class="mx-auto flex max-w-[1200px] items-center justify-between px-4 text-sm font-medium lg:max-w-6xl">
            <div class="hidden items-center space-x-4 sm:flex">
                <div class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Compra com 1 clique</span>
                    <span class="flex items-center gap-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                        Cartão: •••• •••• •••• {{ cardLastDigits }}
                    </span>
                </div>
            </div>
            <div class="hidden items-center space-x-4 sm:flex">
                <div class="flex flex-col">
                    <span class="text-xs uppercase opacity-80">Entrega em</span>
                    <span class="flex items-center gap-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        {{ addressSummary }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
