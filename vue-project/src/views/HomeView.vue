<script setup>

import { usePostStore } from '@/stores/post';
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';

const { fetchPosts } = usePostStore();
const { posts } = storeToRefs(usePostStore());
onMounted(() => {
  fetchPosts();
});
</script>

<template>
  <main>
    <div class="table-responsive">
      <div v-if="posts.length > 0">
        <h1>Hello all posts</h1>
        <table class="table table-primary">
          <thead>
            <tr>
              <th scope="col"> Title </th>
              <th scope="col"> Content</th>
              <th scope="col"> User </th>
            </tr>
          </thead>
          <tbody v-for="post in posts" :key="post.id">
            <tr class="">
              <td scope="row"> {{ post.title }} </td>
              <td> {{ post.content }} </td>
              <td> {{ post.user?.name }} </td>
              <td>
                <RouterLink :to="{ name: 'show', params: { id: post.id } }" class="text-blue-500 font-bold">
                  Show </RouterLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-else>
        <h2> There is not post </h2>
      </div>
    </div>

  </main>
</template>
