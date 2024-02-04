<template>
    <div class="grid grid-cols-3">
        <div></div>
        <div class="my-20 border-2 rounded-md p-5 bg-white">
            <h5 class="text-center mb-5 text-3xl">Welcome Back</h5>
            <div class="mb-4">
                <div class="mb-2 font-bold"><label>Email</label></div>
                <input type="email" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
                    placeholder="e. g. john@example.com" v-model="credentialData.email" name="email" />
            </div>
            <div class="mb-5">
                <div class="mb-2 font-bold"><label>Password</label></div>
                <input type="password" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4" placeholder="* * * * * *"
                 v-model="credentialData.password" name="password" />
            </div>
            <div class="mb-3">
                <EShopButton btnText="Singin" classes="w-full" :onclick="handleSubmit" :disabled="disabled"
                    :loading="loading" />
            </div>
            <div class="">
                <p>Don't have an account? <router-link to="/signup" class="text-blue-500 hover:underline ml-3">Click
                        here</router-link></p>
                <router-link to="/forget-password" class="text-blue-500 hover:underline">Forgot password?</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>

import { computed, ref } from 'vue';
import { EShopButton } from '../components/shared';
import { useAuthStore } from '../store'
import { useRouter } from 'vue-router'


const userStore = useAuthStore();
const router = useRouter();

const credentialData = ref({ email: '', password: '' })
const loading = ref(false)
const disabled = computed(() => !credentialData.value.email || !credentialData.value.password);
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await userStore.userLogin({ ...credentialData.value });
        if (res.success) {
            router.push({ name: 'dashboard' })
            window.location.reload();
        }

    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

</script>