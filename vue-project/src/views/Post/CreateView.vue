<script setup>
import { usePostStore } from '@/stores/post';
import { storeToRefs } from 'pinia';
import { onMounted, reactive } from 'vue';

const { createPost } = usePostStore();
const { errors } = storeToRefs(usePostStore());
const formData = reactive({
    title: '',
    content: '',
});

onMounted(() => errors.value = {});

</script>
<template>
    <div>
        <form @submit.prevent="createPost(formData)" class="w-1/2 mx-auto space-y-6">
            <h1 class="text-center font-mono"> Create Post </h1>
            <div>
                <input type="text" name="title" id="title" placeholder="Title" v-model="formData.title" />
                <p class="text-red-600" v-if="errors.title"> {{ errors.title[0] }} </p>
            </div>
            <div>
                <textarea name="content" id="content" placeholder="Content" v-model="formData.content"></textarea>
                <p class="text-red-600" v-if="errors.content"> {{ errors.content[0] }} </p>
            </div>
            <div>
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Create Post </button>
            </div>
        </form>
    </div>
</template>