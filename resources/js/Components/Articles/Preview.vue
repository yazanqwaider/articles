<script setup>
    import {Link} from '@inertiajs/inertia-vue3';

    defineProps(['article']);
</script>

<template>
    <a :href="route('articles.show', {'article': article.id})" class="w-1/4 m-2 bg-white rounded-lg overflow-hidden shadow-sm">
        <div class="w-full h-80">
            <img :src="article.full_preview_image" alt="article cover image" class="w-full h-full">
        </div>

        <div class="my-2 w-[95%] mx-auto">
            <h4 class="text-lg font-bold">{{ article.shortcut_title }}</h4>
        </div>

        <div class="p-2">
            {{ article.category.name }}
        </div>

        <div>
            <small>{{ article.created_at }}</small>
        </div>
    </a>
</template>