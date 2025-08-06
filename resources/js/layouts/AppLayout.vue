<script setup lang="ts">
import AppLayout from '@/layouts/app/AppTopNavLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
