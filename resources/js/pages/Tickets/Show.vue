<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { destroy, index } from '@/routes/tickets';
import { ref, computed } from 'vue';
import { useTicketEnums } from '@/composables/useTicketEnums';
import { useDatetimeFormat } from '@/composables/useDatetimeFormat';
import Button from '@/components/Button.vue';
import FlashMessage from '@/components/FlashMessage.vue';
import ConfirmationModal from '@/components/ConfirmationModal.vue';
import Edit from './Edit.vue';

interface Ticket {
    id: number;
    title: string;
    description: string;
    status: 'open' | 'in_progress' | 'closed';
    priority: 'low' | 'medium' | 'high';
    created_at: string;
    updated_at: string;
}

const { statusColors, priorityColors } = useTicketEnums();
const { formatDate, formatTime } = useDatetimeFormat();
const page = usePage();

const props = defineProps<{
    ticket: Ticket;
}>();

const flash = computed(() => page.props.flash as any);

const isEditing = ref(false);
const showDeleteConfirm = ref(false);

const enterEditMode = () => {
    isEditing.value = true;
};

const closeEditMode = () => {
    isEditing.value = false;
};

const confirmDelete = () => {
  showDeleteConfirm.value = true;
};

const cancelDelete = () => {
  showDeleteConfirm.value = false;
};

const submitDelete = () => {
  router.delete(destroy(props.ticket.id).url);
};
</script>

<template>
    <Head :title="`Ticket #${ticket.id}`" />

    <FlashMessage
        :success="flash.success"
        :error="flash.error"
    />

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header with back button -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-4">
                        <Link
                        :href="index().url"
                        class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1"
                        >
                            ← Back to Tickets
                        </Link>
                    </div>
                    <h1 class="mt-4 text-3xl font-bold text-gray-900">Ticket #{{ ticket.id }}</h1>
                </div>
            </div>

        <!-- Main content -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Display View -->
            <template v-if="!isEditing">
                <!-- Title section -->
                <div class="px-8 py-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ ticket.title }}</h2>
                </div>

                <!-- Status and Priority section -->
                <div class="px-8 py-6">
                    <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Status</h3>
                        <div class="mt-3">
                        <span :class="statusColors[ticket.status]" class="px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                            {{ ticket.status }}
                        </span>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Priority</h3>
                        <div class="mt-3">
                        <span :class="priorityColors[ticket.priority]" class="px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                            {{ ticket.priority }}
                        </span>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Description section -->
                <div class="px-8 py-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Description</h3>
                    <div class="mt-4 text-gray-700 whitespace-pre-wrap leading-relaxed">
                    {{ ticket.description }}
                    </div>
                </div>
            </template>

            <!-- Edit View -->
            <Edit
                v-else
                :ticket="ticket"
                @close="closeEditMode"
            />

            <!-- Timestams data -->
            <div v-if="!isEditing" class="px-8 py-6">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Created</h3>
                        <p class="mt-2 text-lg text-gray-900">
                            {{ formatDate(ticket.created_at) }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ formatTime(ticket.created_at) }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Last Updated</h3>
                        <p class="mt-2 text-lg text-gray-900">
                            {{ formatDate(ticket.updated_at) }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ formatTime(ticket.updated_at) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions section (only show when not editing) -->
            <div v-if="!isEditing" class="px-8 py-6 border-t border-gray-200 bg-white flex gap-4">
                <Button variant="primary" size="md" @click="enterEditMode">
                    Edit Ticket
                </Button>

                <Button variant="danger" size="md" @click="confirmDelete">
                    Delete Ticket
                </Button>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <ConfirmationModal
            v-if="showDeleteConfirm"
            message="Are you sure you want to delete this ticket? This action cannot be undone."
            @confirm="submitDelete"
            @cancel="cancelDelete"
        />
    </div>
  </div>
</template>