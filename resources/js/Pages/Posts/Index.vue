<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    posts: Object,
});

const page = usePage();
const successMessage = computed(() => page.props.flash?.success);

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        router.delete(route('posts.destroy', id), {
            preserveScroll: true,
        });
    }
};
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
                <div v-if="successMessage"
                    class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                    <span class="block sm:inline">{{ successMessage }}</span>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Latests Posts</h3>
                        <ul>
                            <li v-for="post in posts.data" :key="post.id" class="mb-4 pb-4 border-b last:border-b-0">
                                <h4 class="text=lg font-semibold">
                                    <Link :href="route('posts.show', post.slug)" class="hover:text-indigo-700">
                                    {{ post.title }}
                                    </Link>
                                </h4>

                                <p class="text-sm text-gray-600 mb-2">
                                    By {{ post.user ? post.user.name : 'Unknown Author' }} on {{ new
                                        Date(post.created_at).toLocaleDateString() }}
                                </p>
                                <p>{{ post.body.substring(0, 150) }}...</p>

                                <Link :href="route('posts.show', post.slug)" class="hover:text-indigo-700">
                                Read More &rarr;
                                </Link>

                                <div class="mt-2">
                                    <Link :href="route('posts.edit', post.id)"
                                        class="text-sm text-indigo-600 hover:text-indigo-900"
                                        v-if="$page.props.auth.user.id === post.user_id">
                                    Edit
                                    </Link>

                                    <button @click="deletePost(post.id)"
                                        class="text-sm text-red-600 hover:text-red-900 ml-4"
                                        v-if="$page.props.auth.user.id === post.user_id">
                                        Delete
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>