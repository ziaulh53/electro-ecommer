<template>
    <Layout>
        <div class="grid grid-cols-4">
            <div class="col-span-1"></div>
            <div class="col-span-2 my-20 border-2 rounded-md p-5 bg-white">
                <h5 class="text-center mb-5 text-3xl">Registration</h5>
                <div class="grid grid-cols-2 gap-x-5 mb-5">
                    <EShopInput label="First Name" placeholder="e.g. graham" v-model="credentialData.firstName" />
                    <EShopInput label="Last Name" placeholder="e.g. bell" v-model="credentialData.lastName" />
                    <EShopInput label="Email" type="email" placeholder="e.g. bell@example.com"
                        v-model="credentialData.email" />
                    <EShopInput label="Phone" placeholder="" v-model="credentialData.phone" />
                    <EShopInput label="Password" type="password" placeholder="* * * * * *" v-model="credentialData.password" />
                    <EShopInput label="Confirm Password" type="password" placeholder="* * * * * *" v-model="credentialData.confirmPassword"/>
                </div>
                <div class="mb-3 text-center">
                    <EShopButton btnText="Create Account" classes="w-1/2" :onclick="handleSubmit" :disabled="disabled"
                        :loading="loading" />
                </div>
                <div class="text-center">
                    <p>Already have an Account? <router-link to="/signin" class="text-blue-500 hover:underline ml-3">Click
                            here</router-link></p>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>

import { computed, ref } from 'vue';
import { EShopButton, EShopInput } from '../components/shared';
import { useAuthStore } from '../../store'
import { useRouter } from 'vue-router';
import { Layout } from '../components/Layout';


const userStore = useAuthStore();
const router = useRouter()
const credentialData = ref({ firstName: '', lastName: '', email: '', phone: '', password: '', confirmPassword:'' })
const loading = ref(false)
const disabled = computed(() => {
    const { firstName, lastName, email, phone, password, confirmPassword } = credentialData.value;
    return !firstName || !lastName || !phone || !email || !password || confirmPassword!==password
}
);

const handleSubmit = async () => {
    loading.value = true
    const res = await userStore.userRegistration('signup',{ ...credentialData.value,role: 'user'  });
    loading.value = true
    if (res.success) {
        router.push({ name: 'signin' })
    }
}

</script>

