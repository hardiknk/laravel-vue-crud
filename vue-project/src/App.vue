<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useAuthStore } from './stores/auth';
// import HelloWorld from './components/HelloWorld.vue'
const authStore = useAuthStore();
</script>

<template>
  <header>
    <!-- <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" /> -->

    <div class="wrapper">
      <!-- <HelloWorld msg="You did it!" /> -->

      <nav>
        <RouterLink :to="{ name: 'home' }" class="nav-link">Home</RouterLink>

        <div v-if="authStore.user" class="flex items-center space-x-6">
          <p class="text-sm text-slate-300">
            Welcome back {{ authStore.user.name }}
          </p>

          <RouterLink :to="{ name: 'create_post' }" class="nav-link">
            Create Post
          </RouterLink>

          <form @submit.prevent="authStore.logoutUser">
            <button class="nav-link">Logout</button>
          </form>
        </div>

        <div v-else class="space-x-6">
          <RouterLink :to="{ name: 'register' }" class="nav-link">
            Register
          </RouterLink>
          <RouterLink :to="{ name: 'login' }" class="nav-link">
            Login
          </RouterLink>
        </div>
      </nav>
    </div>
  </header>

  <RouterView />
</template>
