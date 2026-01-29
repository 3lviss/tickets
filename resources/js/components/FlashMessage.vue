<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import Button from './Button.vue';

type MessageType = 'success' | 'error';

interface Message {
    type: MessageType;
    text: string;
}

const props = withDefaults(
    defineProps<{
        success?: string;
        error?: string;
        duration?: number;
    }>(),
    {
        success: '',
        error: '',
        duration: 5000,
    }
);

const messages = ref<Message[]>([]);
const timers = ref<Map<number, NodeJS.Timeout>>(new Map());
let messageId = 0;

const messageStyles = {
    success: 'bg-green-100 text-green-800 border-l-4 border-green-500',
    error: 'bg-red-100 text-red-800 border-l-4 border-red-500',
};

const addMessage = (type: MessageType, text: string) => {
    if (!text) return;

    const id = messageId++;
    messages.value.push({ type, text });

    const timer = setTimeout(() => {
        removeMessage(id);
    }, props.duration);

    timers.value.set(id, timer);
};

const removeMessage = (id: number) => {
    const index = messages.value.findIndex((_, i) => i === id);
    if (index !== -1) {
        messages.value.splice(index, 1);
    }

    const timer = timers.value.get(id);
    if (timer) {
        clearTimeout(timer);
        timers.value.delete(id);
    }
};

const removeAllMessages = () => {
    timers.value.forEach((timer) => clearTimeout(timer));
    timers.value.clear();
    messages.value = [];
};

watch(
    () => props.success,
    (newSuccess) => {
        if (newSuccess) {
            removeAllMessages();
            addMessage('success', newSuccess);
        }
    }
);

watch(
    () => props.error,
    (newError) => {
        if (newError) {
            removeAllMessages();
            addMessage('error', newError);
        }
    }
);

onMounted(() => {
    if (props.success) addMessage('success', props.success);
    if (props.error) addMessage('error', props.error);
});
</script>

<template>
    <div class="fixed top-4 right-4 z-50 space-y-2 max-w-md">
        <transition-group
            tag="div"
            enter-active-class="transition-all duration-300 ease-in-out"
            enter-from-class="translate-x-8 opacity-0"
            enter-to-class="translate-x-0 opacity-100"
            leave-active-class="transition-all duration-300 ease-in-out"
            leave-from-class="translate-x-0 opacity-100"
            leave-to-class="translate-x-8 opacity-0"
        >
            <div
                v-for="(message, index) in messages"
                :key="index"
                :class="messageStyles[message.type]"
                class="px-4 py-3 rounded shadow-lg flex items-center gap-3"
            >
                <span class="flex-1">{{ message.text }}</span>
                <Button
                    variant="ghost"
                    @click="removeMessage(index)"
                    class="p-0 text-lg"
                >x</Button>
            </div>
        </transition-group>
    </div>
</template>