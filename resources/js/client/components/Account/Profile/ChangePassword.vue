<template>
    <a-card class="bg-white">
        <h2 class="text-xl font-semibold mb-5">Change Password</h2>
        <EShopInput label="Current Password" type="password" placeholder="Current password"
            v-model="profileData.currentPassword" />
        <EShopInput label="New Password" type="password" placeholder="New Password" v-model="profileData.newPassword" />
        <EShopInput label="Confirm New Password" type="password" placeholder="Confirm password"
            v-model="profileData.confirmPassword" />
        <div class="text-right">
            <EShopButton btn-text="Update" :onclick="handleUpdateProfile" :disabled="disabled" :loading="loading" />
        </div>
    </a-card>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuthStore } from '../../../../store';
import { EShopInput, EShopButton } from '../../shared';

const { changePassword, userLogout } = useAuthStore();
const loading = ref(false);

const profileData = ref({
    currentPassword: "",
    newPassword: "",
    confirmPassword: ""
})
const disabled = computed(() => !profileData.value.currentPassword || !profileData.value.newPassword || profileData?.value.newPassword !== profileData.value.confirmPassword)

// update profile 
const handleUpdateProfile = async () => {
    loading.value = true;
    const res = await changePassword(profileData.value);
    if (res.success) {
        userLogout();
    }
    loading.value = false;
}
</script>