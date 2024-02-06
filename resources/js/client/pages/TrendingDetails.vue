<template>
    <Layout>
        <div class="grid grid-cols-6 my-8 gap-5">
            <div class="hidden md:block col-span-2 lg:col-span-1">
                <h2 class="font-bold text-2xl mb-5">Filter</h2>
                <div class="p-2 bg-white border rounded-md border-gray-300">
                    <div class="mb-4">
                        <h6 class="text-gray-500">Price</h6>
                        <a-slider v-model:value="filters.maxPrice" @afterChange="onChangePrice" :max="10000" :step="500" />
                    </div>
                </div>
            </div>
            <div v-if="trending?.length" class="col-span-6 md:col-span-4 lg:col-span-5">
                <a-spin :spinning="loading && trending.length">
                    <ProductList :data="{ products: trending }" />
                </a-spin>
            </div>
            <div v-if="loading && !trending?.length" class="col-span-6 md:col-span-4 lg:col-span-5">
                <div class="mb-3">
                    <EShopSkeleton height="41px" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <EShopSkeleton height="300px" type="box" v-for="(_, idx) of new Array(8).fill(null)" :key="idx" />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Layout } from '../components/Layout';
import { ProductList } from '../components/CategoryDetails';
import { api, landingEndpoint } from '../../api';
import { EShopSkeleton } from '../components/shared';
const trending = ref({});
const loading = ref(false);
const filters = ref({
    maxPrice: 10000,
    brands: []
})

const getTrendingProducts = async () => {
    loading.value = true
    try {
        const res = await api.get(landingEndpoint.fetchHomepage, { filters: filters.value })
        trending.value = res?.result?.trendings || [];
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
onMounted(() => {
    getTrendingProducts()
})

const onChangePrice = (value) => {
    filters.value.maxPrice = value;
    getTrendingProducts();
}

</script>