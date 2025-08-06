<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Received Mail" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        Received Mail
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Track and manage incoming mail correspondence.
                    </p>
                    <div class="text-gray-500 dark:text-gray-400">
                        <p>This feature is coming soon!</p>
                        <p class="text-sm mt-2">You'll be able to log and track received mail here.</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 