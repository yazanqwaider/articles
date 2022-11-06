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
import ImageTool from '@editorjs/image';
import Table from '@editorjs/table';

const title = ref(null);
let contentEditor = ref(null);
const preview_image = ref(null);
const tags = ref([]);
let tmpPreviewImageUrl = ref(null);
const category_id = ref(null);

const props = defineProps({
  categories: Array,
  csrf: String
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
            header: Header,
            table: Table,
            image: {
                class: ImageTool,
                config: {
                    endpoints: {
                        byFile: 'http://127.0.0.1:8000/upload-content-article-image',
                        // byUrl: 'http://127.0.0.1:8000/upload-content-article-image'
                    },
                    additionalRequestData: {
                        '_token': props.csrf
                    }
                }
            }
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
                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="flex">
                                <div>
                                    <label for="previewImage" class="border p-2 cursor-pointer rounded-md shadow-sm hover:shadow-lg my-2 transition">
                                        Upload Image 
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            width="30"
                                            height="30"
                                            class="inline-block" viewBox="0 0 512 512">
                                            <title>Image</title><rect x="48" y="80" width="416" height="352" rx="48" ry="48" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="336" cy="176" r="32" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path d="M304 335.79l-90.66-90.49a32 32 0 00-43.87-1.3L48 352M224 432l123.34-123.34a32 32 0 0143.11-2L464 368" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                        </svg>
                                    </label>
                                    <input type="file" id="previewImage" class="hidden" @change="changePreviewImage" accept="image/*">
                                </div>
    
                                <template v-if="tmpPreviewImageUrl">
                                    <img :src="tmpPreviewImageUrl" alt="preview image" class="mx-2 h-36 rounded-md">
                                </template>
                            </div>
                      
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
