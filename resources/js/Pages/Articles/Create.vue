<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';

const title = ref(null);
let contentEditor = ref(null);
const preview_image = ref(null);
const tags = ref([]);
let tmpPreviewImageUrl = ref(null);
const category_id = ref(null);

const props = defineProps({
  categories: Array
});

const form = useForm({
    title: '',
    content: '',
    preview_image: '',
    tags: [],
    category_id: '',
});

const changePreviewImage = (e) => {
    if(e.target.files.length > 0) {
        form.preview_image = e.target.files[0];
        tmpPreviewImageUrl.value = URL.createObjectURL(form.preview_image);
    }
};

const createArticle = async () => {
    try {
        form.content = await contentEditor.save();
    } catch (error) {
        console.log(error);
        form.content = '';
        return false;
    }

    form.post(route('articles.store', {
        errorBag: 'createArticle',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.title) {
                form.reset('title');
                title.value.focus();
            }
        },
    }));
};

onMounted(() => {
    contentEditor = new EditorJS({
        holder: "articleContent",

        tools: {
            header: Header
        }
    });
});
</script>
    
<template>
    <AppLayout title="Create Article">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create new article
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                
                <FormSection @submitted="createArticle">
                    <template #title>
                        Create Article
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="previewImage" value="Image" />

                            <input type="file" id="previewImage" @change="changePreviewImage">

                            <template v-if="tmpPreviewImageUrl">
                                <img :src="tmpPreviewImageUrl" alt="preview image">
                            </template>
                      
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                ref="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="articleContent" value="Content" />

                            <div id="articleContent"></div>

                            <InputError :message="form.errors.content" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="articleCategory" value="Category" />

                            <select id="articleCategory" v-model="form.category_id">
                                <option v-for="category in categories" :value="category.id" :key="'category_'+category.id">
                                    {{ category.name }}
                                </option>
                            </select>

                            <InputError :message="form.errors.category" class="mt-2" />
                        </div>

                    </template>

                    <template #actions>
                        <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>
            </div>
        </div>
    </AppLayout>
</template>
