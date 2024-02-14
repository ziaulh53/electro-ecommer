<template>
    <Layout>
        <div class="grid grid-cols-6 my-8 gap-5" :key="route.params.id">
            <div class="hidden md:block col-span-2 lg:col-span-1">
                <Filters :handleFilterSubmit="handleFilterSubmit" />
            </div>

            <div v-if="categoryDetails?.id" class="col-span-6 md:col-span-4 lg:col-span-5">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-bold text-2xl">{{ categoryDetails?.name }}</h2>
                    <span class="md:hidden"><i class="fa-solid fa-filter text-theme-light"></i></span>
                </div>
                <a-spin :spinning="loading && allProduct?.length>0">
                    <ProductList :data="allProduct" />
                </a-spin>
            </div>
            <div v-if="loading && !allProduct?.length>0" class="col-span-6 md:col-span-4 lg:col-span-5">
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
import { api } from '../../api';
import { useRoute } from 'vue-router';
import { EShopSkeleton } from '../components/shared';
const allProduct = ref([]);
const categoryDetails = ref({});
const loading = ref(false);
const filters = ref({
    maxPrice: 10000,
    brands: []
})
const route = useRoute()

const getCategoryDetails = async () => {
    loading.value = true
    try {
        const res = await api.get('product-by-category/' + route.params.id, { ...filters.value })
        allProduct.value = res?.product;
        categoryDetails.value = res?.category;

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