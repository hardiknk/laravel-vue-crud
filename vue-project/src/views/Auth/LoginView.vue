<script setup>
import { useAuthStore } from '@/stores/auth';
import { storeToRefs } from 'pinia';
import { onMounted, reactive } from 'vue';

const { userLogin } = useAuthStore();
const { errors, custom_error } = storeToRefs(useAuthStore())

const formData = reactive({
    email: '',
    password: '',
});

/** when the page is loaded then the onMounted is called and the error values if already then create it empty */
onMounted(() => {
    errors.value = {}
});

</script>

<template>
    <main>
        <form @submit.prevent="userLogin('login', formData)" class="w-1/2 mx-auto space-y-6">
            <h1 class="text-center font-mono"> Login </h1>
            {{ console.log(custom_error) }}
            <p class="text-red-600" v-if="custom_error"> {{ custom_error }} </p>
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
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Login </button>
            </div>
        </form>
    </main>
</template>
