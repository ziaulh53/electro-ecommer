<template>
    <h6 class="text-lg font-semibold mb-6">Shipping Address</h6>
    <div v-if="!loading && allAddress?.result?.length === 0" class="text-center">
        <router-link to="/account" class="py-2 px-2 bg-theme-color text-white rounded-lg">+ Add Address</router-link>
    </div>
    <div class="grid md:grid-cols-2 gap-x-5">
        <a-radio-group v-model="selectAddress" @change="handleChooseAddress">
            <a-radio v-for="address of allAddress.result" :value="address?._id" class="mb-5">
                <div class="px-5">
                    <p class="font-semibold text-lg">{{ address?.firstName + " " + address?.lastName }}</p>
                    <p class="text-base">{{ address?.apertment }} , {{ address?.address }}</p>
                    <p class="text-base">{{ address?.city }}, {{ address?.state }}-{{ address?.zipCode }} , {{
                        address?.country }}</p>
                    <p class="text-base"> <i class="fa-solid fa-phone text-sm mr-2"></i>{{ address?.phone }}</p>
                </div>
            </a-radio>
        </a-radio-group>
    </div>
</template>

<script setup>
import { ref, onMounted, toRefs } from 'vue';
import { addressEndpoint, api } from '../../../api';

const props = defineProps({
    handleShippingAddress: Function
})

const { handleShippingAddress } = toRefs(props)

const allAddress = ref({})
const selectAddress = ref('')
const loading = ref(false)

const getAddress = async () => {
    loading.value = true
    try {
        allAddress.value = await api.get(addressEndpoint.getAddress);
    } catch (error) {
        console.log(error)
    }
    loading.value = false;
}

onMounted(() => {
    getAddress();
})


const handleChooseAddress = e => {
    selectAddress.value = e.target.value
    const findAddress = allAddress.value.result?.find(res => res?._id === e.target.value);
    delete findAddress.user;
    delete findAddress._id;
    handleShippingAddress.value(findAddress);
}

</script>