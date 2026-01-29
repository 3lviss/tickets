<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store, index } from '@/routes/tickets';
import { useTicketEnums } from '@/composables/useTicketEnums';
import Button from '@/components/Button.vue';

const { statuses, priorities } = useTicketEnums();

const form = useForm({
    title: '',
    description: '',
    status: 'open',
    priority: 'low',
});

const submitForm = () => {
    form.post(store().url, {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Create Ticket" />

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header with back button -->
            <div class="mb-8">
                <div class="flex items-center gap-4">
                <Link
                    :href="index().url"
                    class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1"
                >
                    ← Back to Tickets
                </Link>
                </div>
                <h1 class="mt-4 text-3xl font-bold text-gray-900">Create New Ticket</h1>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitForm" class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Title section -->
                <div class="px-8 py-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        :class="form.errors.title ? 'border-red-500' : 'border-gray-300'"
                        placeholder="Enter ticket title"
                    />
                    <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Status and Priority section -->
                <div class="px-8 py-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select
                                :value="form.status"
                                @change="(e) => form.status = (e.target as HTMLSelectElement).value"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                :class="form.errors.status ? 'border-red-500' : 'border-gray-300'"
                            >
                                <option v-for="status in statuses" :key="status" :value="status">
                                {{ status }}
                                </option>
                            </select>
                            <p v-if="form.errors.status" class="mt-2 text-sm text-red-600">
                                {{ form.errors.status }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select
                                :value="form.priority"
                                @change="(e) => form.priority = (e.target as HTMLSelectElement).value"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                :class="form.errors.priority ? 'border-red-500' : 'border-gray-300'"
                            >
                                <option v-for="priority in priorities" :key="priority" :value="priority">
                                {{ priority }}
                                </option>
                            </select>
                            <p v-if="form.errors.priority" class="mt-2 text-sm text-red-600">
                                {{ form.errors.priority }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description section -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea
                        v-model="form.description"
                        rows="8"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        :class="form.errors.description ? 'border-red-500' : 'border-gray-300'"
                        placeholder="Enter ticket description"
                    />
                    <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">
                        {{ form.errors.description }}
                    </p>
                </div>

                <!-- Actions section -->
                <div class="px-8 py-6 border-t border-gray-200 bg-white flex gap-4">
                    <Button
                        type="submit"
                        variant="primary"
                        :disabled="form.processing"
                        class="inline-flex items-center gap-2"
                    >
                        <span v-if="form.processing" class="inline-block animate-spin">⏳</span>
                        <span>{{ form.processing ? 'Creating...' : 'Create Ticket' }}</span>
                    </Button>

                    <Link :href="index().url" class="px-4 py-2 bg-gray-200 text-gray-900 rounded-md font-medium hover:bg-gray-300 transition-colors cursor-pointer inline-flex items-center">
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>