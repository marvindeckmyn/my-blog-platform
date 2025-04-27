<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    post: Object,
});

const formattedDate = computed(() => {
    if (!props.post?.created_at) return '';
    return new Date(props.post.created_at).toLocaleDateString('nl-BE', {
        year: 'numeric', month: 'long', day: 'numeric'
    });
});
</script>

<template>
    <Head :title="post.title" /> <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">View Post</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <Link :href="route('posts.index')" class="text-indigo-600 hover:text-indigo-900">&larr; Back to Posts</Link>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            {{ post.title }}
                        </h1>

                        <div class="text-sm text-gray-600 mb-6">
                            Posted by {{  post.user ? post.user.name : 'Unknown Author' }} on {{  formattedDate }}
                        </div>

                        <div class="prose prose-lg max-w-none text-gray-800">
                            {{ post.body }}
                        </div>

                        <div class="mt-8 border-t pt-4">
                            <Link
                                v-if="post.user_id === $page.props.auth.user.id"
                                :href="route('posts.edit', post.id)"
                                class="text-sm text-indigo-600 hover:text-indigo-900"
                            >
                                Edit Post
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>