<template>
    <div class="grid grid-cols-3">
        <div></div>
        <div class="my-20 border-2 rounded-md p-5 bg-white">
            <h5 class="text-center mb-5 text-3xl">Forget password</h5>
            <div class="mb-4">
                <div class="mb-2 font-bold"><label>Email</label></div>
                <input type="email" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
                    placeholder="e. g. john@example.com" v-model="email" name="email" />
            </div>
            <div class="mb-3">
                <!-- <button type="primary" :onClick="handleSubmit" :disabled="disabled || loading" class="w-full btn-class">
                        <span v-if="loading"> <i class="fa-solid fa-spinner fa-spin mr-2"></i></span>
                        Send Email
                    </button> -->
                <EShopButton btnText="Send Email" classes="w-full" :onclick="handleSubmit" :disabled="disabled"
                    :loading="loading" />
            </div>
            <div class="text-center">
                <router-link to="/signin" class="text-blue-500 hover:underline ml-3">
                    Go Back
                </router-link>
            </div>
        </div>
    </div>
</template>


<script setup>

import { computed, ref } from 'vue';
import { useAuthStore } from '../store'
import { Layout } from '../components/Layout';
import { EShopButton } from '../components/shared';
const emailRegx = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const userStore = useAuthStore();

const email = ref('')
const loading = ref(false)
const disabled = computed(() => !email.value || !emailRegx.test(email.value));

const handleSubmit = async () => {
    loading.value = true
    try {
        await userStore.forgetPassword({ email: email.value });
    } catch (error) {
        console.log(error)
    }
    loading.value = false

}

</script>