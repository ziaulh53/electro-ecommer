<template>
    <div v-if="!loading" class="grid grid-cols-3 gap-5 mb-5">
        <AddressItem v-for="data of allAddress" :key="data?.id" :address="data" :refetch="fetchAddress" />
    </div>
    <div v-if="loading" class="grid grid-cols-3 gap-5 mb-5">
        <EShopSkeleton v-for="i of 3" :key="i" height="280px"/>
    </div>
    <div class="text-right">
        <EShopButton btn-text="Add Address" :onclick="onModalOpen" />
    </div>
    <a-modal title="Add new address" v-model:open="open" @ok="handleAddAddress" :ok-button-props="{ disabled: disabled }">
        <AddressForm :address-data="addressData" />
    </a-modal>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import { EShopButton, EShopSkeleton } from '../shared';
import { AddressItem, AddressForm } from './Address';
import { addressEndpoint, api } from '../../../api';
import { notify } from '../../../helpers';

const allAddress = ref([]);
const loading = ref(false);
const open = ref(false);

const addressData = ref({
    firstName: '',
    lastName: '',
    apartment: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    zipCode: '',
    country: ''
})

const disabled = computed(() => !addressData?.value.firstName || !addressData?.value.lastName || !addressData?.value.apartment || !addressData?.value.address || !addressData?.value.phone || !addressData?.value.zipCode || !addressData?.value.city || !addressData?.value.state || !addressData?.value.country)

const fetchAddress = async () => {
    loading.value = true;
    try {
        const res = await api.get(addressEndpoint.getAddress);
        allAddress.value = res?.addresses;
    } catch (error) {
        console.log(error)
    }
    loading.value = false;
}
onMounted(() => {
    fetchAddress();
})

const handleAddAddress = async () => {
    try {
        const res = await api.post(addressEndpoint.getAddress, { ...addressData.value });
        notify(res, fetchAddress)
        open.value = false;
    } catch (error) {
        console.log(error)
    }
}

const onModalOpen = () => {
    open.value = true
}
</script>