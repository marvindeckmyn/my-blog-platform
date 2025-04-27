<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});
</script>

<template>
    <div v-if="links.length > 3" class="flex justify-center mt-4 space-x-1">
        <template v-for="(link, key) in links" :key="key">
            <span
                v-if="link.url === null"
                class="px-4 py-2 text-sm leading-4 text-gray-400 border rounded cursor-not-allowed"
                v-html="link.label"
            />
            <span
                v-else-if="link.active"
                class="px-4 py-2 text-sm leading-4 text-white bg-indigo-500 border border-indigo-500 rounded cursor-pointer"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                class="px-4 py-2 text-sm leading-4 text-gray-700 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
                v-html="link.label"
            />
        </template>
    </div>
</template>