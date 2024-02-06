<template>
    <Layout>
        <div class="grid grid-cols-3">
            <div></div>
            <div class="my-20 border-2 rounded-md p-5 bg-white">
                <h5 class="text-center mb-5 text-3xl">Welcome Back</h5>
                <div class="mb-4">
                    <div class="mb-2 font-bold"><label>New Password</label></div>
                    <input type="password" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
                        placeholder="* * * * * *" @input="onChange" v-model="credentialData.password" name="email" />
                </div>
                <div class="mb-5">
                    <div class="mb-2 font-bold"><label>Confirm Password</label></div>
                    <input type="password" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
                        placeholder="* * * * * *" @input="onChange" v-model="credentialData.confirmPassword"
                        name="password" />
                </div>
                <div class="mb-3">
                    <EShopButton btnText="Reset Password" classes="w-full" :onclick="handleSubmit" :disabled="disabled"
                        :loading="loading" />
                </div>
                <div class="text-center">
                    <router-link to="/" class="text-blue-500 hover:underline ml-3">Home
                    </router-link>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>

import { computed, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { EShopButton } from '../components/shared';
import { useAuthStore } from '../../store'
import { Layout } from '../components/Layout';
const userStore = useAuthStore();
const route = useRoute()
const router = useRouter();

const credentialData = ref({ confirmPassword: '', password: '' })
const loading = ref(false)
const disabled = computed(() => !credentialData.value.password || credentialData.value.password !== credentialData.value.confirmPassword);

const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await userStore.resetPassword({ newPassword: credentialData.value.password, token: route.query.security_key })
        if(res.success){
            router.push({name:'signin'})
        }
    } catch (error) {
        console.log(error)
    }
    loading.value = false

}

</script>