<script setup>
import { useAuthStore } from '@/stores/auth';
import { storeToRefs } from 'pinia';
import { onMounted, reactive } from 'vue';

const { authenticateUser } = useAuthStore();
const { errors } = storeToRefs(useAuthStore())

const formData = reactive({
    name: '',
    email: '',
    password: '',
    confirm_password: ''
});

onMounted(() => errors.value = {});
</script>

<template>
    <main>
        <form @submit.prevent="authenticateUser('register', formData)" class="w-1/2 mx-auto space-y-6">
            <h1 class="text-center font-mono">Register a new user </h1>
            <!-- <h1 class="text-center font-mono">Register a new user {{ authStore.userName }} </h1> -->
            <div>
                <input type="text" name="name" id="name" placeholder="Name" v-model="formData.name" />
                <p class="text-red-600" v-if="errors.name"> {{ errors.name[0] }} </p>
            </div>
            <div>
                <input type="email" name="email" id="email" placeholder="Email" v-model="formData.email" />
                <p class="text-red-600" v-if="errors.email"> {{ errors.email[0] }} </p>
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Password"
                    v-model="formData.password" />
                <p class="text-red-600" v-if="errors.password"> {{ errors.password[0] }} </p>

            </div>
            <div>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                    v-model="formData.confirm_password" />
            </div>
            <div>
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Register</button>
            </div>
        </form>
    </main>
</template>
