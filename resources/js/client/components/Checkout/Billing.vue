<template>
    <h6 class="text-lg font-semibold mb-6">Billing Address</h6>
    <div class="grid grid-cols-2 gap-x-5">
        <EShopInput label="First Name" placeholder="first name" v-model="billingAddress.firstName" />
        <EShopInput label="Last Name" placeholder="last name" v-model="billingAddress.lastName" />
        <EShopInput label="Apertment (optional)" placeholder="apertment" v-model="billingAddress.apartment" />
        <EShopInput label="Phone" placeholder="phone number" v-model="billingAddress.phone" />
        <EShopInput label="Address" placeholder="address" v-model="billingAddress.address" />
        <EShopInput label="City" placeholder="city" v-model="billingAddress.city" />
        <EShopInput label="State" placeholder="state" v-model="billingAddress.state" />
        <EShopInput label="Country" placeholder="Country" v-model="billingAddress.country" />
    </div>
</template>

<script setup>
import { EShopInput } from '../shared';

defineProps({
    billingAddress: Object
})

</script>