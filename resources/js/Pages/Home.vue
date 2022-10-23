<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ArticleTemplate from '@/Components/Articles/Preview.vue';

const props = defineProps({
    top_rated_articles: Array,
    random_articles: Array
});
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <h2 class="text-xl font-bold mb-2">Top Rated Articles ✨</h2>

            <div class="flex">
                <ArticleTemplate 
                    v-for="(article, index) in top_rated_articles" 
                    :key="'top_rated_' + index"
                    :article="article">
                </ArticleTemplate>
            </div>
        </div>
    </AppLayout>
</template>
