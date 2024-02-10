<template>
    <Layout>
        <div class="my-10 grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="hidden md:block">
                <Brands />
            </div>
            <div class="col-span-2 rounded-lg">
                <EShopSkeleton height="400px" v-if="loading" />
                <Poster v-if="homepageData?.banners?.length" :posters="homepageData?.banners" />
            </div>
        </div>
        <div class="border bg-white p-5 rounded-md mb-10">
            <div class="flex justify-between mb-5">
                <h2 class="font-semibold text-xl text-theme-color">
                    <i class="fa-solid fa-arrow-trend-up mr-2 text-red-600"></i>Trending Now
                </h2>
                <router-link to="/trending"
                    class="font-semibold p-3 rounded-lg text-white bg-red-600 hover:bg-red-500 transition-all">Show
                    More</router-link>
            </div>
            <div v-if="loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                <EShopSkeleton height="300px" v-if="loading" v-for="(_idx) of new Array(5).fill(null)" />
            </div>
            <ECarousel v-if="!trendLoading" :items="trending?.map(({product})=>product)" />
        </div>
        <NewArrival />
        <Categories />
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Poster, Categories, Brands, NewArrival } from '../components/Home';
import { Layout } from '../components/Layout';
import { api } from '../../api';
import { EShopSkeleton, ECarousel } from '../components/shared';

const homepageData = ref({});
const loading = ref(false);
const trendLoading = ref(false);
const trending = ref([]);

const getHomepageData = async () => {
    loading.value = true
    try {
        homepageData.value = await api.get('banner');
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

const getTrendingData = async ()=>{
    trendLoading.value = true;
    try {
        const res = await api.get('product/trending');
        trending.value = res.trendings;
    } catch (error) {
        console.log(error);
    }
    trendLoading.value = false;
}

onMounted(() => {
    getHomepageData();
    getTrendingData();
})


</script>