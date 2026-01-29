<script setup lang="ts">
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import Button from './Button.vue';

interface FilterData {
    search: string;
    status: string;
    priority: string;
}

const props = withDefaults(
    defineProps<{
        statuses?: string[];
        priorities?: string[];
        initialSearch?: string;
        initialStatus?: string;
        initialPriority?: string;
    }>(),
    {
        statuses: () => ['open', 'in_progress', 'closed'],
        priorities: () => ['low', 'medium', 'high'],
        initialSearch: '',
        initialStatus: '',
        initialPriority: '',
    }
);

const filterData = ref<FilterData>({
    search: props.initialSearch,
    status: props.initialStatus,
    priority: props.initialPriority,
});

const emit = defineEmits<{
    search: [value: string];
    filter: [filters: FilterData];
    reset: [];
}>();

const debouncedSearch = useDebounceFn((searchValue: string) => {
    emit('search', searchValue);
}, 500);

const debouncedFilter = useDebounceFn((filters: FilterData) => {
    emit('filter', filters);
}, 300);

watch(
    () => filterData.value.search,
    (newSearch) => {
        debouncedSearch(newSearch);
    }
);

watch(
    () => filterData.value.status,
    () => {
        debouncedFilter(filterData.value);
    }
);

watch(
    () => filterData.value.priority,
    () => {
        debouncedFilter(filterData.value);
    }
);

const resetFilter = () => {
    filterData.value = {
        search: '',
        status: '',
        priority: '',
    };
    emit('reset');
};
</script>

<template>
    <div class="bg-white shadow rounded-lg p-3 md:p-6 mb-4 md:mb-8">
        <!-- Mobile Layout -->
        <div class="md:hidden space-y-4">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    v-model="filterData.search"
                    type="text"
                    placeholder="Search by title or description..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Status and Priority -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select
                        v-model="filterData.status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Statuses</option>
                        <option v-for="status in statuses" :key="status" :value="status">
                            {{ status }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select
                        v-model="filterData.priority"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">All Priorities</option>
                        <option v-for="priority in priorities" :key="priority" :value="priority">
                            {{ priority }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Reset Button -->
            <div>
                <Button
                    variant="secondary"
                    @click="resetFilter"
                    class="w-full mt-2 md:mt-0"
                >
                    Reset
                </Button>
            </div>
        </div>

        <!-- Desktop Layout -->
        <div class="hidden md:grid grid-cols-4 gap-4 items-end">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input
                    v-model="filterData.search"
                    type="text"
                    placeholder="Search by title or description..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                    v-model="filterData.status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">All Statuses</option>
                    <option v-for="status in statuses" :key="status" :value="status">
                        {{ status }}
                    </option>
                </select>
            </div>

            <!-- Priority Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <select
                    v-model="filterData.priority"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">All Priorities</option>
                    <option v-for="priority in priorities" :key="priority" :value="priority">
                        {{ priority }}
                    </option>
                </select>
            </div>

            <!-- Reset Button -->
            <div>
                <Button
                    variant="secondary"
                    @click="resetFilter"
                    class="w-full"
                >
                    Reset
                </Button>
            </div>
        </div>
    </div>
</template>