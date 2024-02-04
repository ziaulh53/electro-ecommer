<template>
    <button
        class="border-red-500 border rounded-lg py-2 px-5 text-red-500 hover:bg-red-500 hover:text-white  transition-colors duration-300 transform"
        @click="handleButtonClick" :disabled="wishLoading">
        <span v-if="!wishLoading"><i class="fa-regular fa-heart"></i></span> <span v-else><i
                class="fa-solid fa-spinner"></i></span> Add to Wish</button>

    <a-modal v-model:open="isOpen" title="Login to add wish list" :footer="false">
        <div class="bg-white">
            <EShopInput label="Email" type="email" placeholder="e. g. john@example.com" v-model="credentialData.email" />
            <EShopInput label="Password" type="password" placeholder="* * * * * *" v-model="credentialData.password" />
            <div class="mb-3">
                <EShopButton btnText="Singin" classes="w-full" :onclick="handleSubmit" :disabled="disabled"
                    :loading="loading" />
            </div>
        </div>
    </a-modal>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useAuthStore } from '../../store';
import { EShopButton, EShopInput } from '../shared';
import { api, wishEndpoint } from '../../api';
import { useRoute } from 'vue-router';
import { notify } from '../../helpers';

const credentialData = ref({ email: '', password: '' })

const { user, userLogin } = useAuthStore();
const route = useRoute()
const isOpen = ref(false)
const loading = ref(false)
const wishLoading = ref(false)
const disabled = computed(() => !credentialData.value.email || !credentialData.value.password);

const onAddWishList = async () => {
    wishLoading.value = true
    try {
        const res = await api.post(wishEndpoint.addWish, { productId: route.params.id })
        notify(res)

    } catch (error) {

    }
    wishLoading.value = false;
}

const onLoginModal = () => {
    isOpen.value = true;
}
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await userLogin({ ...credentialData.value });
        if (res.success) {
            window.location.reload()
        }

    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

const handleButtonClick = () => {
    user.isAuthenticated ? onAddWishList() : onLoginModal();
}
</script>