<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { update } from '@/routes/tickets';
import { useTicketEnums } from '@/composables/useTicketEnums';
import Button from '@/components/Button.vue';

const { statuses, priorities } = useTicketEnums();

interface Ticket {
    id: number;
    title: string;
    description: string;
    status: 'open' | 'in_progress' | 'closed';
    priority: 'low' | 'medium' | 'high';
}

interface Props {
    ticket: Ticket;
}

interface Emits {
    close: [];
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

// Initialize form with ticket data
const form = useForm({
    title: props.ticket.title,
    description: props.ticket.description,
    status: props.ticket.status,
    priority: props.ticket.priority,
});

// Submit edit
const submitEdit = () => {
    form.put(update(props.ticket.id).url, {
        onSuccess: () => {
            emit('close');
        },
    });
};

// Cancel edit
const cancelEdit = () => {
    form.reset();
    emit('close');
};
</script>

<template>
    <!-- Header section -->
    <div class="px-8 py-6 border-b border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900">Edit Ticket</h2>
    </div>

    <!-- Title section -->
    <div class="px-8 py-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
        <input
            v-model="form.title"
            type="text"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            :class="form.errors.title ? 'border-red-500' : 'border-gray-300'"
            placeholder="Enter ticket title"
            :disabled="form.processing"
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
            v-model="form.status"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            :class="form.errors.status ? 'border-red-500' : 'border-gray-300'"
            :disabled="form.processing"
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
            v-model="form.priority"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            :class="form.errors.priority ? 'border-red-500' : 'border-gray-300'"
            :disabled="form.processing"
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
        :disabled="form.processing"
    />
    <p v-if="form.errors.description" class="mt-2 text-sm text-red-600">
        {{ form.errors.description }}
    </p>
  </div>

  <!-- Actions section -->
  <div class="px-8 py-6 border-t border-gray-200 bg-white flex gap-4">
    <Button
        variant="primary"
        size="md"
        :disabled="!form.isDirty || form.processing"
        @click="submitEdit"
        class="inline-flex items-center gap-2"
    >
        <span>{{ form.processing ? 'Saving...' : 'Save Changes' }}</span>
    </Button>

    <Button
        variant="secondary"
        size="md"
        :disabled="form.processing"
        @click="cancelEdit"
    >
        Cancel
    </Button>
  </div>
</template>