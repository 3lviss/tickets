<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { index, create, show, destroy } from '@/routes/tickets';
import { useTicketEnums } from '@/composables/useTicketEnums';
import { useDatetimeFormat } from '@/composables/useDatetimeFormat';
import Datatable from '@/components/Datatable.vue';
import Pagination from '@/components/Pagination.vue';
import Button from '@/components/Button.vue';
import FlashMessage from '@/components/FlashMessage.vue';
import ConfirmationModal from '@/components/ConfirmationModal.vue';

const page = usePage();
const { statusColors, priorityColors } = useTicketEnums();
const { formatDate } = useDatetimeFormat();

interface Ticket {
    id: number;
    title: string;
    description: string;
    status: 'open' | 'in_progress' | 'closed';
    priority: 'low' | 'medium' | 'high';
    created_at: string;
}

interface PaginatedTickets {
    data: Ticket[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

interface Props {
    tickets: PaginatedTickets;
}

const props = withDefaults(defineProps<Props>(), {
});

const flash = computed(() => page.props.flash as any);

const showDeleteConfirm = ref(false);
const ticketToDelete = ref<number | null>(null);

const columns = [
    {
        key: 'id',
        label: 'ID',
    },
    {
        key: 'title',
        label: 'Title',
    },
    {
        key: 'status',
        label: 'Status',
    },
    {
        key: 'priority',
        label: 'Priority',
    },
    {
        key: 'created_at',
        label: 'Created At',
    },
];

const handleEdit = (ticketId: number) => {
    router.visit(show(ticketId).url);
};

const handleDelete = (ticketId: number) => {
    ticketToDelete.value = ticketId;
    showDeleteConfirm.value = true;
};

const confirmDelete = () => {
    if (ticketToDelete.value) {
        router.delete(destroy(ticketToDelete.value).url, {
            onSuccess: () => {
                showDeleteConfirm.value = false;
                ticketToDelete.value = null;
            },
        });
    }
};

const cancelDelete = () => {
    showDeleteConfirm.value = false;
    ticketToDelete.value = null;
};

const buildPaginationUrl = (page: number) => {
  return index({
    query: {
      page,
    },
  }).url;
};
</script>

<template>
    <Head title="Tickets" />

    <FlashMessage
        :success="flash.success"
        :error="flash.error"
    />

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tickets</h1>

                    <p class="mt-2 text-gray-600 text-sm">
                        Showing {{ tickets.from }} to {{ tickets.to }} of {{ tickets.total }}
                        tickets
                    </p>

                </div>

                <Link :href="create().url">
                    <Button variant="primary">
                        Create Ticket
                    </button>
                </Link>
            </div>

            <!-- Datatable Component -->
            <Datatable
                :columns="columns"
                :data="(tickets as any)"
            >
                <template #cell-id="{ value }">
                    #{{ value }}
                </template>

                <template #cell-title="{ row }">
                    <Link :href="show((row as unknown as Ticket).id).url" class="text-blue-600 hover:text-blue-800 hover:underline">
                        {{ row.title }}
                    </Link>
                </template>

                <template #cell-status="{ value }">
                    <span :class="statusColors[value as string]" class="rounded-full px-3 py-1 text-xs font-semibold">
                        {{ value }}
                    </span>
                </template>

                <template #cell-priority="{ value }">
                    <span :class="priorityColors[value as string]" class="rounded-full px-3 py-1 text-xs font-semibold">
                        {{ value }}
                    </span>
                </template>

                <template #cell-created_at="{ value }">
                    {{ formatDate(value as string) }}
                </template>

                <template #actions="{ row }">
                    <div class="flex gap-2">
                        <Button
                            variant="ghost"
                            @click="handleEdit((row as unknown as Ticket).id)"
                            class="cursor-pointer p-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                        </Button>

                        <Button
                            variant="danger"
                            @click="handleDelete((row as unknown as Ticket).id)"
                            class="cursor-pointer p-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>
                        </Button>
                    </div>
                </template>
            </Datatable>

            <!-- Pagination -->
            <Pagination
                :pagination="{ current_page: tickets.current_page, last_page: tickets.last_page }"
                :build-url="buildPaginationUrl"
            />

            <!-- Delete Confirmation Modal -->
            <ConfirmationModal
                v-if="showDeleteConfirm"
                message="Are you sure you want to delete this ticket? This action cannot be undone."
                @confirm="confirmDelete"
                @cancel="cancelDelete"
            />
        </div>
    </div>
</template>