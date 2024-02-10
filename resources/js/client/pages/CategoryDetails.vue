<template>
    <Layout>
        <div class="grid grid-cols-6 my-8 gap-5" :key="route.params.id">
            <div class="hidden md:block col-span-2 lg:col-span-1">
                <Filters :brands="category?.brands" :handleFilterSubmit="handleFilterSubmit" />
            </div>

            <div v-if="category?.products?.length" class="col-span-6 md:col-span-4 lg:col-span-5">
                <a-spin :spinning="loading && category?.products?.length">
                    <ProductList :data="category" />
                </a-spin>
            </div>
            <div v-if="loading && !category?.products?.length" class="col-span-6 md:col-span-4 lg:col-span-5">
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
import { onMounted, ref, watch } from 'vue';
import { Layout } from '../components/Layout';
import { Filters, ProductList } from '../components/CategoryDetails';
import { api, categoryEndpoint } from '../../api';
import { useRoute } from 'vue-router';
import { EShopSkeleton } from '../components/shared';
const category = ref('');
const loading = ref(false);
const filters = ref({
    maxPrice: 10000,
    brands: []
})
const route = useRoute()

const getCategoryDetails = async () => {
    loading.value = true
    try {
        const res = await api.get(categoryEndpoint.fetchSingleCategory + route.params.id, { ...filters.value })
        category.value = res?.category;
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
onMounted(() => {
    getCategoryDetails()
})

// Watch for changes in the route.params.id
watch(() => route.params.id, () => {
    getCategoryDetails();
});
const handleFilterSubmit = (filter) => {
    filters.value = {
        ...filter
    }
    getCategoryDetails()
}


</script>