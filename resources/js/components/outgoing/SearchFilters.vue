<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { X } from 'lucide-vue-next';
import { ref, watch, computed } from 'vue';

interface Props {
    modelValue: {
        username: string;
        country: string;
        region: string;
    };
}

interface Emits {
    (e: 'update:modelValue', value: { username: string; country: string; region: string }): void;
    (e: 'search'): void;
    (e: 'clear'): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

// Local reactive state for the filters
const filters = ref({
    username: props.modelValue.username || '',
    country: props.modelValue.country || '',
    region: props.modelValue.region || '',
});

// Reactive refs for the country/region selects
const selectedCountry = ref(props.modelValue.country || '');
const selectedRegion = ref(props.modelValue.region || '');

// Watch for changes and emit updates
watch(filters, (newFilters) => {
    emit('update:modelValue', { ...newFilters });
}, { deep: true });

// Watch country changes to update the filter
watch(selectedCountry, (newCountry) => {
    filters.value.country = newCountry;
    // Clear region when country changes
    if (newCountry !== filters.value.country) {
        filters.value.region = '';
        selectedRegion.value = '';
    }
});

// Watch region changes to update the filter
watch(selectedRegion, (newRegion) => {
    filters.value.region = newRegion;
});

// Handle search action
const handleSearch = () => {
    emit('search');
};

// Handle clear action
const handleClear = () => {
    filters.value = {
        username: '',
        country: '',
        region: '',
    };
    selectedCountry.value = '';
    selectedRegion.value = '';
    emit('clear');
};

// Check if any filters are active
const hasActiveFilters = computed(() => {
    return filters.value.username || filters.value.country || filters.value.region;
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Search Filters
            </h3>
            <Button
                v-if="hasActiveFilters"
                variant="outline"
                size="sm"
                @click="handleClear"
                class="text-sm"
            >
                <X class="h-4 w-4 mr-1" />
                Clear All
            </Button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Username Filter -->
            <div class="space-y-2">
                <Label for="search-username">Search by Username</Label>
                <Input
                    id="search-username"
                    v-model="filters.username"
                    type="text"
                    placeholder="Enter username..."
                    class="w-full"
                />
            </div>

            <!-- Country Filter -->
            <div class="space-y-2">
                <Label for="search-country">Search by Country</Label>
                <country-select 
                    v-model="selectedCountry" 
                    :country="selectedCountry"
                    placeholder="Select a country..."
                    class="w-full"
                />
            </div>

            <!-- Region Filter -->
            <div class="space-y-2">
                <Label for="search-region">Search by State/Region</Label>
                <region-select 
                    v-model="selectedRegion"
                    :country="selectedCountry" 
                    :region="selectedRegion"
                    placeholder="Select a state/region..."
                    class="w-full"
                    :disabled="!selectedCountry"
                />
                <p v-if="!selectedCountry" class="text-xs text-gray-500 dark:text-gray-400">
                    Select a country first
                </p>
            </div>
        </div>

        <!-- Search Actions -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-2">
                <Button 
                    @click="handleSearch"
                    class="bg-blue-600 hover:bg-blue-700 text-white"
                >
                    Search
                </Button>
                <Button
                    v-if="hasActiveFilters"
                    variant="outline"
                    @click="handleClear"
                >
                    Clear Filters
                </Button>
            </div>
            
            <!-- Active Filters Indicator -->
            <div v-if="hasActiveFilters" class="text-sm text-gray-600 dark:text-gray-400">
                <span class="font-medium">{{ Object.values(filters).filter(Boolean).length }}</span> 
                filter(s) active
            </div>
        </div>

        <!-- Active Filter Tags -->
        <div v-if="hasActiveFilters" class="flex flex-wrap gap-2 mt-3">
            <span
                v-if="filters.username"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300"
            >
                Username: {{ filters.username }}
                <button @click="filters.username = ''" class="ml-1 hover:text-blue-600">
                    <X class="h-3 w-3" />
                </button>
            </span>
            
            <span
                v-if="filters.country"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300"
            >
                Country: {{ filters.country }}
                <button @click="selectedCountry = ''; filters.country = ''" class="ml-1 hover:text-green-600">
                    <X class="h-3 w-3" />
                </button>
            </span>
            
            <span
                v-if="filters.region"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300"
            >
                Region: {{ filters.region }}
                <button @click="selectedRegion = ''; filters.region = ''" class="ml-1 hover:text-purple-600">
                    <X class="h-3 w-3" />
                </button>
            </span>
        </div>
    </div>
</template> 