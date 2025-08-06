<script setup lang="ts">
import TopNavigation from '@/components/TopNavigation.vue';
import type { BreadcrumbItem } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <TopNavigation :breadcrumbs="breadcrumbs" />
        <main class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template> 