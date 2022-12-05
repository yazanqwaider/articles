<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps(['article']);

onMounted(() => {
    let editorJsViewer = new HtmlViewer(props.article.content);
    editorJsViewer.render("#htmlEditorContent");
});

</script>

<template>
    <AppLayout title="Show Article">
        <template #header>
            <div class="flex items-center mx-2">
                <img :src="article.author.profile_photo_url" class="rounded-lg w-11" alt="Author Image">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mx-3">{{ article.author.name }}</h2>
            </div>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 bg-white h-full">
                <div class="flex justify-between mb-5">
                    <div>
                        <h1 class="font-bold text-2xl">{{ article.title }}</h1>
                        <span class="text-sm text-gray-600">{{ article.created_at.slice(0, 10) }}</span>
                    </div>

                    <div>
                        <h3 class="text-md">Category: <b class="font-bold">{{ article.category.name }}</b></h3>
                    </div>
                </div>
                <hr>

                <div class="text-center bg-gray-300 bg-opacity-10 mt-5 mb-10">
                    <img :src="article.full_preview_image" class="max-h-72 mx-auto rounded-lg" alt="Preview Image">
                </div>

                <div id="htmlEditorContent" class="p-4"></div>
            </div>
        </div>
    </AppLayout>
</template>