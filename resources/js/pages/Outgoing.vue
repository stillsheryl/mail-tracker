<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import AddOutgoing from '@/components/outgoing/AddOutgoing.vue';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const showModal = ref(false);

</script>

<template>
    <Head title="Outgoing Mail" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="m-5 flex items-center">
            <div class="grow text-3xl font-bold">
                Outgoing Mail
            </div>
            <button id="show-modal" @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add outgoing mail
            </button>
            <!-- use the modal component, pass in the prop -->
            <AddOutgoing v-if="showModal" @close="showModal = false" />

            <!-- <a href="https://www.name.com">
                Click me
            </a> -->

        </div>
        <div class="flex h-full flex-1 flex-col-3 gap-4 rounded-xl p-4 overflow-x-auto">
            <div>Search by username</div>
            <div>All countries</div>
            <div>All time</div>
        </div>
    </AppLayout>
</template>
