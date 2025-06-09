<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import type { BreadcrumbItem, User } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, Search, User as UserIcon } from 'lucide-vue-next';
import { computed, ref } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth as { user: User });
const searchQuery = ref('');
const isSearchOpen = ref(false);
const isMobileMenuOpen = ref(false);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        // TODO: Implementar a lógica de pesquisa aqui
        isSearchOpen.value = false;
    }
};
</script>

<template>
    <header class="mb-6 w-full max-w-[1200px] text-sm lg:max-w-6xl">
        <nav class="relative flex items-center justify-center gap-4">
            <!-- Menu Mobile (esquerda) - Visível apenas em telas pequenas -->
            <div class="absolute left-0 md:hidden">
                <Sheet v-model:open="isMobileMenuOpen">
                    <SheetTrigger as-child>
                        <button class="flex items-center justify-center rounded-full p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800">
                            <Menu class="h-5 w-5 text-neutral-700 dark:text-neutral-300" />
                        </button>
                    </SheetTrigger>
                    <SheetContent side="left" class="w-full max-w-[280px] p-6 sm:w-[280px]">
                        <div class="flex flex-col gap-6 py-4">
                            <div class="flex flex-col gap-4">
                                <h3 class="text-lg font-semibold">Menu</h3>

                                <!-- Usuário em Mobile -->
                                <div v-if="$page.props.auth.user" class="flex items-center gap-3 rounded-md bg-neutral-50 p-3 dark:bg-neutral-800/50">
                                    <Avatar>
                                        <AvatarImage :src="$page.props.auth.user.avatar ?? ''" alt="@unovue" />
                                        <AvatarFallback>{{ $page.props.auth.user.name.charAt(0) }}</AvatarFallback>
                                    </Avatar>
                                    <div>
                                        <p class="text-sm font-medium">{{ $page.props.auth.user.name }}</p>
                                        <Link :href="route('dashboard')" class="text-xs text-neutral-500">Dashboard</Link>
                                    </div>
                                </div>

                                <!-- Login em Mobile -->
                                <Link
                                    v-else
                                    :href="route('login')"
                                    class="flex items-center gap-3 rounded-md px-4 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                                >
                                    <UserIcon class="h-5 w-5" />
                                    <span>Fazer login</span>
                                </Link>

                                <!-- Pesquisa em Mobile -->
                                <button
                                    class="flex items-center gap-3 rounded-md px-4 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                                    @click="
                                        isSearchOpen = true;
                                        isMobileMenuOpen = false;
                                    "
                                >
                                    <Search class="h-5 w-5" />
                                    <span>Pesquisar</span>
                                </button>
                            </div>
                        </div>
                    </SheetContent>
                </Sheet>
            </div>

            <!-- Centro - Logo (centralizado na página) -->
            <div class="flex items-center justify-center">
                <AppLogo />
            </div>

            <!-- Lado direito - Ícones e Login (apenas visível em telas médias e maiores) -->
            <div class="absolute right-0 hidden items-center gap-4 md:flex">
                <!-- Ícone de busca com Dialog -->
                <Dialog v-model:open="isSearchOpen">
                    <DialogTrigger as-child>
                        <button
                            class="flex items-center justify-center rounded-full p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                            @click="isSearchOpen = true"
                        >
                            <Search class="h-5 w-5 text-neutral-700 dark:text-neutral-300" />
                        </button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Buscar no site</DialogTitle>
                            <DialogDescription> Digite o que você está procurando </DialogDescription>
                        </DialogHeader>
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-2">
                                <Input
                                    v-model="searchQuery"
                                    placeholder="Pesquise produtos, categorias..."
                                    class="flex-1"
                                    @keyup.enter="handleSearch"
                                />
                                <Button @click="handleSearch">Buscar</Button>
                            </div>
                        </div>
                    </DialogContent>
                </Dialog>

                <!-- Usuário conectado -->
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="flex items-center justify-center gap-2 rounded-sm px-3 py-1.5 text-sm leading-normal text-[#1b1b18] hover:bg-neutral-100 dark:text-[#EDEDEC] dark:hover:bg-neutral-800"
                >
                    Hello {{ $page.props.auth.user.name }}

                    <Avatar>
                        <AvatarImage :src="$page.props.auth.user.avatar ?? ''" alt="@unovue" />
                        <AvatarFallback>{{ $page.props.auth.user.name.charAt(0) }}</AvatarFallback>
                    </Avatar>
                </Link>

                <!-- Usuário não conectado -->
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="flex items-center justify-center rounded-full p-2 hover:bg-neutral-100 dark:hover:bg-neutral-800"
                    >
                        <UserIcon class="h-5 w-5 text-neutral-700 dark:text-neutral-300" />
                    </Link>
                </template>
            </div>
        </nav>
    </header>
</template>
