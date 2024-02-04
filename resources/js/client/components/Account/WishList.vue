<template></template>

<script setup>
import { onMounted } from 'vue'
import { api, wishEndpoint } from '../../api';


const getWishList = async () => {

    try {
        const res = await api.get(wishEndpoint.getWishItems);
        // selectedColors.value = product.value.result?.colors[0];
        // loading.value = false
    } catch (error) {
        console.log(error)
    }

}

onMounted(() => {
    getWishList()
})
</script>