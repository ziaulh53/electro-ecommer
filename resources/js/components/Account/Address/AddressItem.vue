<template>
    <a-card class="bg-white" :hoverable="true">
        <div>
            <p class="font-semibold text-lg">{{ address?.firstName + " " + address?.lastName }}</p>
            <p class="text-base">{{ address?.apertment }} , {{ address?.address }}</p>
            <p class="text-base">{{ address?.city }}, {{ address?.state }}-{{ address?.zipCode }} , {{ address?.country }}</p>
            <p class="text-base"> <i class="fa-solid fa-phone text-sm mr-2"></i>{{ address?.phone }}</p>
        </div>
        <template class="ant-card-actions" #actions>
            <span @click="handleDelete"><i class="fa-solid fa-trash text-red-600"></i></span>
            <span @click="handleOpenModal"><i class="fa-solid fa-pen-to-square"></i></span>
        </template>
    </a-card>
    <a-modal v-model:open="open" @ok="handleUpdate" title="Update address" :ok-button-props="{ disabled: disabled }">
        <AddressForm :address-data="addressData" />
    </a-modal>
</template>

<script setup>
import { toRefs, ref, computed } from 'vue';
import { addressEndpoint, api } from '../../../api';
import { notify } from '../../../helpers';
import AddressForm from './AddressForm.vue';

const props = defineProps({
    address: Object,
    refetch: Function
})
const { address, refetch } = toRefs(props);
const addressData = ref({
    firstName: address?.value.firstName,
    lastName: address?.value.lastName,
    apertment: address?.value.apertment,
    phone: address?.value.phone,
    address: address?.value.address,
    city: address?.value.city,
    state: address?.value.state,
    zipCode: address?.value.zipCode,
    country: address?.value.country
})

const open = ref(false);
const disabled = computed(() => !addressData?.value.firstName || !addressData?.value.lastName || !addressData?.value.apertment || !addressData?.value.address || !addressData?.value.phone || !addressData?.value.zipCode || !addressData?.value.city || !addressData?.value.state || !addressData?.value.country)


const handleDelete = async () => {
    try {
        const res = await api.delete(addressEndpoint.deleteAddress, address.value?._id);
        notify(res, refetch.value)
    } catch (error) {
        console.log(error)
    }
}

const handleOpenModal = () => {
    open.value = true
}
const handleUpdate = async () => {
    try {
        const res = await api.put(addressEndpoint.editAddress, address.value?._id, { address: { ...addressData.value } });
        notify(res, refetch.value)
    } catch (error) {
        console.log(error)
    }
    open.value = false
}
</script>