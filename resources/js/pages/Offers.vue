<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AddOutgoing from '@/components/outgoing/AddOutgoing.vue';
import { ref, watch } from 'vue';

type OutgoingRecord = {
    id: number;
    date: string;
    username: string;
    name?: string;
    city?: string;
    region?: string;
    country: string;
    occasion?: string;
    description?: string;
    thanked: boolean;
    has_been_sent: boolean;
    created_at: string;
    updated_at: string;
};

const props = defineProps<{
    success?: string;
    outgoing?: OutgoingRecord[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const showModal = ref(false);

// Create a reactive copy of the outgoing records for optimistic updates
const outgoingRecords = ref<OutgoingRecord[]>(props.outgoing || []);

// Watch for prop changes and update reactive records when new data comes from server
watch(() => props.outgoing, (newOutgoing: OutgoingRecord[] | undefined) => {
    if (newOutgoing) {
        outgoingRecords.value = [...newOutgoing];
    }
}, { immediate: true });

// Toggle thanked status
const toggleThanked = async (record: OutgoingRecord) => {
    const originalThanked = record.thanked;
    
    // Optimistic update - update UI immediately
    const recordIndex = outgoingRecords.value.findIndex((r: OutgoingRecord) => r.id === record.id);
    if (recordIndex !== -1) {
        outgoingRecords.value[recordIndex].thanked = !originalThanked;
    }

    try {
        // Make API request to update the database
        await fetch(route('outgoing.updateThanked', { outgoing: record.id }), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
        });
    } catch (error) {
        // Revert optimistic update on error
        if (recordIndex !== -1) {
            outgoingRecords.value[recordIndex].thanked = originalThanked;
        }
        console.error('Failed to update thanked status:', error);
    }
};

// Toggle has_been_sent status
const toggleHasBeenSent = async (record: OutgoingRecord) => {
    const originalStatus = record.has_been_sent;
    
    // Optimistic update - remove from current list immediately
    const recordIndex = outgoingRecords.value.findIndex((r: OutgoingRecord) => r.id === record.id);
    if (recordIndex !== -1) {
        // Remove from offers list since it will move to sent
        outgoingRecords.value.splice(recordIndex, 1);
    }

    try {
        // Make API request to update the database
        await fetch(route('outgoing.updateHasBeenSent', { outgoing: record.id }), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
        });
    } catch (error) {
        // Revert optimistic update on error - add record back to list
        if (recordIndex !== -1) {
            outgoingRecords.value.splice(recordIndex, 0, record);
        }
        console.error('Failed to update has_been_sent status:', error);
    }
};
</script>

<template>
    <Head title="Offers" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Success Message -->
        <div v-if="success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ success }}
        </div>
        
        <div class="mb-6 flex items-center">
            <div class="grow text-3xl font-bold">
                Offers
            </div>
            <button id="show-modal" @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add outgoing mail
            </button>
            <AddOutgoing :open="showModal" @close="showModal = false" />
        </div>

        <!-- Offers Table -->
        <div>
            <div v-if="outgoingRecords && outgoingRecords.length > 0" class="overflow-x-auto shadow-md rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Date</th>
                            <th scope="col" class="px-6 py-3">Username</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">City</th>
                            <th scope="col" class="px-6 py-3">State</th>
                            <th scope="col" class="px-6 py-3">Country</th>
                            <th scope="col" class="px-6 py-3">Occasion</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Thanked</th>
                            <th scope="col" class="px-6 py-3">Has Been Sent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="record in outgoingRecords" :key="record.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ new Date(record.date).toLocaleDateString() }}
                            </td>
                            <td class="px-6 py-4">{{ record.username }}</td>
                            <td class="px-6 py-4">{{ record.name || '-' }}</td>
                            <td class="px-6 py-4">{{ record.city || '-' }}</td>
                            <td class="px-6 py-4">{{ record.region || '-' }}</td>
                            <td class="px-6 py-4">{{ record.country }}</td>
                            <td class="px-6 py-4">{{ record.occasion || '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs truncate" :title="record.description">
                                    {{ record.description || '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button 
                                    @click="toggleThanked(record)"
                                    :class="[
                                        'inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 cursor-pointer hover:shadow-md',
                                        record.thanked 
                                            ? 'bg-green-100 text-green-800 hover:bg-green-200 border border-green-300' 
                                            : 'bg-red-100 text-red-800 hover:bg-red-200 border border-red-300'
                                    ]"
                                >
                                    <span v-if="record.thanked">✓ Yes</span>
                                    <span v-else>✗ No</span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <button 
                                    @click="toggleHasBeenSent(record)"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-medium transition-colors duration-200 cursor-pointer hover:shadow-md bg-orange-100 text-orange-800 hover:bg-orange-200 border border-orange-300"
                                    title="Click to mark as sent and move to Sent page"
                                >
                                    <span>📮 Send</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <div class="text-gray-500 text-lg mb-4">No pending offers yet</div>
                <p class="text-gray-400 mb-6">Start by adding your first outgoing mail offer.</p>
                <button @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Your First Offer
                </button>
            </div>
        </div>
    </AppLayout>
</template> 