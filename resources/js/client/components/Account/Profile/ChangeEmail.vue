<template>
    <a-card class="bg-white">
        <h2 class="text-xl font-semibold mb-5">Change Email</h2>
        <EShopInput label="Password" type="password" placeholder="* * * * * *" v-model="profileData.password" />
        <EShopInput label="New Email" type="email" placeholder="New email" v-model="profileData.newEmail" />
        <div class="text-right">
            <EShopButton btn-text="Update" :onclick="handleUpdateProfile" :disabled="disabled" :loading="loading" />
        </div>
    </a-card>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuthStore } from '../../../../store';
import { EShopInput, EShopButton } from '../../shared';

const { changeEmail, userLogout } = useAuthStore();
const loading = ref(false);

const profileData = ref({
    password: "",
    newEmail: "",
})
const disabled = computed(() => !profileData.value.newEmail || !profileData.value.password)

// update profile 
const handleUpdateProfile = async () => {
    loading.value = true;
    const res = await changeEmail(profileData.value);
    if (res.success) {
        setTimeout(() => {
            userLogout();
        }, 3000)
    }
    loading.value = false;
}
</script>