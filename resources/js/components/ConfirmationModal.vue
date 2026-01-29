<script setup lang="ts">
import Button from './Button.vue';

withDefaults(
    defineProps<{
        message?: string;
    }>(),
    {
        message: 'Are you sure?',
    }
);

const emit = defineEmits<{
    confirm: [];
    cancel: [];
}>();
</script>

<template>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Confirm Action</h3>
            </div>

            <div class="px-6 py-4">
                <p class="text-gray-700">{{ message }}</p>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 flex gap-3 justify-end">
                <Button variant="secondary" @click="emit('cancel')">
                    Cancel
                </Button>

                <Button variant="danger" @click="emit('confirm')">
                    Confirm
                </Button>
            </div>
        </div>
    </div>
</template>