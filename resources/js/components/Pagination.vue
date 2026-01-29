<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface PaginationData {
    current_page: number;
    last_page: number;
}

interface Props {
    pagination: PaginationData;
    buildUrl: (page: number) => string;
}

defineProps<Props>();
</script>

<template>
    <div v-if="pagination.last_page > 1" class="mt-8 flex items-center justify-between">
        <div class="text-xs text-gray-600">
            Page {{ pagination.current_page }} of {{ pagination.last_page }}
        </div>

        <div class="flex space-x-2">
            <Link
                preserve-scroll
                v-if="pagination.current_page > 1"
                :href="buildUrl(pagination.current_page - 1)"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
            >
                Previous
            </Link>

            <Link
                preserve-scroll
                v-if="pagination.current_page < pagination.last_page"
                :href="buildUrl(pagination.current_page + 1)"
                class="px-4 py-2 text-sm font-medium text-white bg-teal-500 border border-transparent rounded-md hover:bg-teal-600"
            >
                Next
            </Link>
        </div>
    </div>
</template>