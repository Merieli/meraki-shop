<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, CreditCard, Folder, LayoutGrid, MapPin, Package, ShoppingBag } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
        admin: true,
    },
    {
        title: 'Register Product',
        href: '/products/create',
        icon: Package,
        admin: true,
    },
    {
        title: 'My Orders',
        href: '/orders',
        icon: ShoppingBag,
        admin: false,
    },
    {
        title: 'Register Address',
        href: '/addresses/create',
        icon: MapPin,
        admin: false,
    },
    {
        title: 'Register Card',
        href: '/cards/create',
        icon: CreditCard,
        admin: false,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/Merieli/meraki-shop',
        icon: Folder,
        admin: true,
    },
    {
        title: 'Documentation API',
        href: '/docs/api',
        icon: BookOpen,
        admin: true,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
