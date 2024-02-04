<template>
    <a-card class="bg-white">
        <h2 class="text-xl font-semibold mb-5">Basic Info</h2>
        <div class="grid grid-cols-3 gap-5">
            <EShopInput label="First Name" type="text" placeholder="first name" v-model="profileData.firstName" />
            <EShopInput label="Last Name" type="text" placeholder="last name" v-model="profileData.lastName" />
            <EShopInput label="Phone" type="text" placeholder="phone" v-model="profileData.phone" />
        </div>

        <div class="mb-5">
            <div class="font-bold mb-5">Avater</div>
            <a-spin :spinning="fileLoading">
                <div class="w-[100px] h-[100px] mb-3">
                    <img :src="profileData?.avatar || '/assets/logo.png'" class="w-full h-full" alt="">
                </div>
            </a-spin>

            <input type="file" @change="uploadFile" />
        </div>
        <div class="text-right">
            <EShopButton btn-text="Update" :onclick="handleUpdateProfile" :loading="loading" :disabled="disabled" />
        </div>
    </a-card>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuthStore } from '../../../store';
import { api } from '../../../api';
import { EShopInput, EShopButton } from '../../shared';

const { user, updateProfile } = useAuthStore();
const loading = ref(false);
const fileLoading = ref(false);

const profileData = ref({
    firstName: user?.user?.firstName || "",
    lastName: user?.user?.lastName || "",
    phone: user?.user?.phone || "",
    avatar: user?.user?.avatar || ""
})

const disabled = computed(() => !profileData.value.firstName || !profileData.value.lastName || !profileData.value.phone)

const uploadFile = async e => {
    fileLoading.value = true;
    try {
        const res = await api.fileUpload(e.target.files[0]);
        profileData.value.avatar = res.result.url;
        console.log(res)
    } catch (error) {
        console.log(error)
    }
    fileLoading.
        value = false;
}

// update profile 
const handleUpdateProfile = async () => {
    loading.value = true;
    await updateProfile(profileData.value);
    loading.value = false
}
</script>