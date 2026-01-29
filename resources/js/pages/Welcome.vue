<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { index } from '@/routes/tickets';
import Button from '@/components/Button.vue';
</script>

<template>
    <Head title="Welcome" />
    <div class="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div class="text-center">
            <h1 class="mb-4 text-4xl font-bold text-gray-900 dark:text-white">
                Check your tickets
            </h1>
            <p class="mb-8 text-lg text-gray-600 dark:text-gray-400">
                See all tickets and manage them
            </p>
            <Link :href="index().url">
                <Button variant="primary" size="lg">
                    View Tickets
                </Button>
            </Link>
        </div>
    </div>
</template>