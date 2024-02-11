<template>
    <div class="grid grid-cols-2 gap-x-5">
        <EShopInput label="First Name" type="text" placeholder="first name" v-model="addressData.firstName" />
        <EShopInput label="Last Name" placeholder="last name" v-model="addressData.lastName" />
        <EShopInput label="Apertment (optional)" placeholder="apertment" v-model="addressData.apartment" />
        <EShopInput label="Phone" type="number" placeholder="phone number" v-model="addressData.phone" />
        <div class="col-span-2">
             <EShopInput label="Address" :is-text-area="true" placeholder="address" v-model="addressData.address" />
        </div>
        <EShopInput label="City" placeholder="city" v-model="addressData.city" />
        <EShopInput label="Zip Code" placeholder="zip code" v-model="addressData.zipCode" />
        <EShopInput label="State" placeholder="state" v-model="addressData.state" />
        <EShopInput label="Country" placeholder="Country" v-model="addressData.country" />
    </div>
</template>

<script setup>
import { toRefs } from 'vue'
import { EShopInput } from '../../shared';
const props = defineProps({
    addressData: Object,
})
const { addressData } = toRefs(props);


</script>