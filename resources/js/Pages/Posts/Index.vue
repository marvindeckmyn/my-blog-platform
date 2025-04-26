<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    posts: Object,
});
</script>

<template>
    <Head title="Blog Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blog Posts</h2>
                <Link :href="route('posts.create')">
                    <PrimaryButton>Create New Post</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Latests Posts</h3>
                        <ul>
                            <li v-for="post in posts.data" :key="post.id" class="mb-4 pb-4 border-b last:border-b-0">
                                <h4 class="text=lg font-semibold">{{ post.title }}</h4>
                                <p class="text-sm text-gray-600 mb-2">
                                    By {{ post.user ? post.user.name : 'Unknown Author' }} on {{ new Date(post.created_at).toLocaleDateString() }}
                                </p>
                                <p>{{ post.body.substring(0,150) }}...</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>