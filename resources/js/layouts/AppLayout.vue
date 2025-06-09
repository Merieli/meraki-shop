<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { setApiToken } from '@/utils/apiTokenStore';
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();

onMounted(() => {
    const token = page.props.api_token as string | undefined;
    if (token) {
        setApiToken(token);
        delete page.props.api_token;
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
