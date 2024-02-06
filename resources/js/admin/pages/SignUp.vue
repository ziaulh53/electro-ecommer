<template>
    <div class="grid grid-cols-4">
        <div class="col-span-1"></div>
        <div class="col-span-2 my-20 border-2 rounded-md p-5 bg-white">
            <h5 class="text-center mb-5 text-3xl">Registration</h5>
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <div class="mb-2 font-bold"><label>Name</label></div>
                    <input class="w-full border-2 border-gray-300 rounded-lg p-2 px-4" placeholder="e. g. john" name="name"
                        v-model="credentialData.name" />
                </div>
                <div>
                    <div class="mb-2 font-bold"><label>Email</label></div>
                    <input class="w-full border-2 border-gray-300 rounded-lg p-2 px-4 " placeholder="e. g. john@example.com"
                        v-model="credentialData.email" />
                </div>
                <div>
                    <div class="mb-2 font-bold"><label>Password</label></div>
                    <input class="w-full border-2 border-gray-300 rounded-lg p-2 px-4 " placeholder="* * * * * *"
                        v-model="credentialData.password" />
                </div>
                <div>
                    <div class="mb-2 font-bold"><label>Confirm Password</label></div>
                    <input class="w-full border-2 border-gray-300 rounded-lg p-2 px-4 " placeholder="* * * * * *" />
                </div>
            </div>
            <div class="mb-3 text-center">
                <EShopButton btnText="Create Account" classes="w-1/2" :onclick="handleSubmit" :disabled="disabled"
                    :loading="loading" />
            </div>
            <div class="text-center">
                <p>Already have an Account? <router-link to="/admin" class="text-blue-500 hover:underline ml-3">Click
                        here</router-link></p>
            </div>
        </div>
    </div>
</template>

<script setup>

import { computed, ref } from 'vue';
import { EShopButton } from '../components/shared';
import { useRouter } from 'vue-router';
import { Layout } from '../components/Layout';
import { api } from '../../api';

const router = useRouter()
const credentialData = ref({ name: '', email: '', password: '' })
const loading = ref(false)
const disabled = computed(() => {
    const { name, email, password } = credentialData.value;
    return !name || !email || !password
}
);

const handleSubmit = async () => {
    loading.value = true
    const res = await api.post('admin/signup',{ ...credentialData.value, role:'super_admin' });
    loading.value = true
    if (res.success) {
        router.push({ name: 'admin-signin' })
    }
}

</script>

