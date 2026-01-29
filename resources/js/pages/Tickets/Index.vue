<script setup lang="ts">
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { index } from '@/routes/tickets';
import Datatable from '@/components/Datatable.vue';
import Pagination from '@/components/Pagination.vue';

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
    // Edit
};

const handleDelete = (ticketId: number) => {
    // Delete
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

                <Link href="#">
                    <button>
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
                    <Link href="#" class="text-blue-600 hover:text-blue-800 hover:underline">
                        {{ row.title }}
                    </Link>
                </template>

                <template #actions="{ row }">
                    <div class="flex gap-2">
                        <button
                            @click="handleEdit((row as unknown as Ticket).id)"
                            class="cursor-pointer p-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                />
                            </svg>
                        </button>

                        <button
                            @click="handleDelete((row as unknown as Ticket).id)"
                            class="cursor-pointer p-1"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                />
                            </svg>
                        </button>
                    </div>
                </template>
            </Datatable>

            <!-- Pagination -->
            <Pagination
                :pagination="{ current_page: tickets.current_page, last_page: tickets.last_page }"
                :build-url="buildPaginationUrl"
            />
        </div>
    </div>
</template>