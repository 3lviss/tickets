<script setup lang="ts">
type ButtonVariant = 'primary' | 'secondary' | 'danger' | 'ghost';

withDefaults(
    defineProps<{
        variant?: ButtonVariant;
        disabled?: boolean;
        customClass?: string;
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        variant: 'primary',
        disabled: false,
        type: 'button',
    }
);

const variantClasses: Record<ButtonVariant, string> = {
    primary: 'bg-teal-500 text-white hover:bg-teal-600',
    secondary: 'bg-gray-200 text-gray-900 hover:bg-gray-300',
    danger: 'text-red-600 hover:text-red-900',
    ghost: 'text-blue-600 hover:text-blue-900',
};
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        class="cursor-pointer px-4 py-2 text-md rounded-md font-medium transition-colors disabled:cursor-not-allowed disabled:opacity-50"
        :class="[variantClasses[variant], customClass]"
    >
        <slot />
    </button>
</template>