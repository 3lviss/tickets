<script setup lang="ts">

interface Column {
    key: string;
    label: string;
}

interface PaginationData {
    data: Record<string, unknown>[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

withDefaults(
    defineProps<{
        columns: Column[];
        data: PaginationData;
        loading?: boolean;
    }>(),
    {
        loading: false,
    }
);
</script>

<template>
  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-teal-100">
        <tr>
            <th
                v-for="column in columns"
                :key="column.key"
                class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider"
            >
                {{ column.label }}
            </th>
            <th
                v-if="$slots.actions"
                class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider"
            >
                Actions
            </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="(row, index) in data.data" :key="index" class="hover:bg-gray-50">
            <td
                v-for="column in columns"
                :key="column.key"
                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
            >
                <slot :name="`cell-${column.key}`" :row="row" :value="row[column.key]">
                {{ row[column.key] }}
                </slot>
            </td>
            <td v-if="$slots.actions" class="px-6 py-4 whitespace-nowrap text-sm">
                <slot name="actions" :row="row" />
            </td>
        </tr>
      </tbody>
    </table>

    <!-- No data message -->
    <div v-if="data.data.length === 0" class="px-6 py-12 text-center text-gray-500">
        <p class="text-sm">No records found</p>
    </div>
  </div>
</template>