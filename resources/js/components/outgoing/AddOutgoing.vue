<script setup lang="ts">
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps<{
    open: boolean;
}>();

const emit = defineEmits<{
    close: [];
}>();

// Form data using Inertia's useForm
const form = useForm({
    username: '',
    name: '',
    date: '',
    country: '',
    region: '',
    city: '',
    occasion: '',
    description: '',
    link: '',
    thanked: false,
    has_been_sent: false,
});

// Reset form when modal opens/closes
watch(() => props.open, (isOpen) => {
    if (!isOpen) {
        form.reset();
    }
});

const handleSubmit = () => {
    form.post(route('outgoing.store'), {
        onSuccess: () => {
            emit('close');
            // You might want to show a success message here
        },
        onError: (errors) => {
            console.error('Form errors:', errors);
        }
    });
};

const handleClose = () => {
    emit('close');
};
</script>

<template>
            <Dialog :open="open" @update:open="(value: boolean) => !value && handleClose()">
        <DialogContent class="sm:max-w-[600px] max-h-[80vh] overflow-y-auto">
            <DialogHeader>
                <DialogTitle>Add Outgoing Mail</DialogTitle>
                <DialogDescription>
                    Create a new outgoing mail record. Fill in the required information below.
                </DialogDescription>
            </DialogHeader>
            
            <form @submit.prevent="handleSubmit" class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <!-- Username (Required) -->
                    <div class="space-y-2">
                        <Label for="username">Username *</Label>
                        <Input
                            id="username"
                            v-model="form.username"
                            type="text"
                            placeholder="Enter username"
                            :class="{ 'border-red-500': form.errors.username }"
                            required
                        />
                        <div v-if="form.errors.username" class="text-red-500 text-sm">
                            {{ form.errors.username }}
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="space-y-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Enter full name"
                            :class="{ 'border-red-500': form.errors.name }"
                        />
                        <div v-if="form.errors.name" class="text-red-500 text-sm">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <!-- Date (Required) -->
                    <div class="space-y-2">
                        <Label for="date">Date *</Label>
                        <Input
                            id="date"
                            v-model="form.date"
                            type="date"
                            :class="{ 'border-red-500': form.errors.date }"
                            required
                        />
                        <div v-if="form.errors.date" class="text-red-500 text-sm">
                            {{ form.errors.date }}
                        </div>
                    </div>

                    <!-- Country (Required) -->
                    <div class="space-y-2">
                        <Label for="country">Country *</Label>
                        <Input
                            id="country"
                            v-model="form.country"
                            type="text"
                            placeholder="Enter country"
                            :class="{ 'border-red-500': form.errors.country }"
                            required
                        />
                        <div v-if="form.errors.country" class="text-red-500 text-sm">
                            {{ form.errors.country }}
                        </div>
                    </div>

                    <!-- Region -->
                    <div class="space-y-2">
                        <Label for="region">Region</Label>
                        <Input
                            id="region"
                            v-model="form.region"
                            type="text"
                            placeholder="Enter region/state"
                            :class="{ 'border-red-500': form.errors.region }"
                        />
                        <div v-if="form.errors.region" class="text-red-500 text-sm">
                            {{ form.errors.region }}
                        </div>
                    </div>

                    <!-- City -->
                    <div class="space-y-2">
                        <Label for="city">City</Label>
                        <Input
                            id="city"
                            v-model="form.city"
                            type="text"
                            placeholder="Enter city"
                            :class="{ 'border-red-500': form.errors.city }"
                        />
                        <div v-if="form.errors.city" class="text-red-500 text-sm">
                            {{ form.errors.city }}
                        </div>
                    </div>

                    <!-- Occasion -->
                    <div class="space-y-2">
                        <Label for="occasion">Occasion</Label>
                        <Input
                            id="occasion"
                            v-model="form.occasion"
                            type="text"
                            placeholder="Enter occasion (e.g., Birthday, Holiday)"
                            :class="{ 'border-red-500': form.errors.occasion }"
                        />
                        <div v-if="form.errors.occasion" class="text-red-500 text-sm">
                            {{ form.errors.occasion }}
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <Label for="description">Description</Label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="3"
                            placeholder="Enter description or notes"
                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            :class="{ 'border-red-500': form.errors.description }"
                        ></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-sm">
                            {{ form.errors.description }}
                        </div>
                    </div>

                    <!-- Link -->
                    <div class="space-y-2">
                        <Label for="link">Link</Label>
                        <Input
                            id="link"
                            v-model="form.link"
                            type="url"
                            placeholder="https://example.com"
                            :class="{ 'border-red-500': form.errors.link }"
                        />
                        <div v-if="form.errors.link" class="text-red-500 text-sm">
                            {{ form.errors.link }}
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <input
                                id="thanked"
                                v-model="form.thanked"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <Label for="thanked" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Thanked
                            </Label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input
                                id="has_been_sent"
                                v-model="form.has_been_sent"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            />
                            <Label for="has_been_sent" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Has Been Sent
                            </Label>
                        </div>
                    </div>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" @click="handleClose">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creating...' : 'Create Outgoing Mail' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>