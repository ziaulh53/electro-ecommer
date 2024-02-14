<template>
    <div class="border bg-white p-5 rounded-md mb-10">
        <div class="flex justify-between mb-5">
            <h2 class="font-semibold text-xl text-theme-color">
                <i class="fa-solid fa-plane-arrival mr-2"></i>New Arrivals
            </h2>
            <router-link to="/new-arrival"
                class="font-semibold px-3 py-1 rounded-lg text-white bg-red-600 hover:bg-red-500 transition-all">Show
                More</router-link>
        </div>
        <div v-if="loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            <EShopSkeleton height="300px" v-if="loading" v-for="(_idx) of new Array(5).fill(null)" />
        </div>
        <ECarousel v-if="!loading" :items="newArrival.product" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { api, productEndpoint } from '../../../api';
import { ECarousel, EShopSkeleton } from '../shared';

const newArrival = ref({});
const loading = ref(false);

const getNewArrival = async () => {
    loading.value = true
    try {
        newArrival.value = await api.get(productEndpoint.fetchNewArrival)
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(() => {
    getNewArrival();
})
</script>