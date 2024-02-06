<template>
    <Layout>
        <PageTitle title="Product" />
        <div class="my-5" v-if="categoryDetails?.result?._id">
            <CreateProduct :refetch="fetchSingleCategory" :categoryData="categoryDetails?.result"
                :allColors="allColors.result" />
        </div>
        <a-spin :spinning="loading">
            <div class="h-[300px]" v-if="loading && !categoryDetails?.result?._id"></div>
            <div class="grid grid-cols-4 gap-5" v-if="categoryDetails?.result?._id">
                <SingleProduct v-for="product of categoryDetails.result?.products" :key="product._id" :product="product"
                    :refetch="fetchSingleCategory" :allColors="allColors.result" :allBrands="categoryDetails?.result?.brands" />
            </div>
        </a-spin>

    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Layout } from '../components/Layout';
import { api, categoryAdmin, colorAdmin } from '../../api';
import { useRoute } from 'vue-router'
import { PageTitle } from '../components/shared';
import { SingleProduct, CreateProduct } from '../components/Products'
const router = useRoute();
const loading = ref(false);
const allColors = ref([]);
const categoryDetails = ref({});
const fetchSingleCategory = async () => {
    loading.value = true
    try {
        categoryDetails.value = await api.get(categoryAdmin.getCategory + '/' + router.params.id)
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
const getAllColor = async () => {
    try {
        allColors.value = await api.get(colorAdmin.getColors);
    } catch (error) {
        console.log(error)
    }
}
onMounted(() => {
    fetchSingleCategory()
    getAllColor()
})



</script>