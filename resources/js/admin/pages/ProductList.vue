<template>
    <Layout>
        <PageTitle title="Product" />
        <div class="my-5" v-if="categoryDetails?.id">
            <CreateProduct :refetch="fetchSingleCategory" :categoryData="categoryDetails"
                :allColors="allColors.data" />
        </div>
        <a-spin :spinning="loading">
            <div class="h-[300px]" v-if="loading && !categoryDetails?.id"></div>
            <div class="grid grid-cols-4 gap-5" v-if="categoryDetails?.id">
                <SingleProduct v-for="product of categoryDetails?.products" :key="product.id" :product="product"
                    :refetch="fetchSingleCategory" :allColors="allColors.data" :allBrands="categoryDetails?.brands" />
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
const allProducts = ref({});

const fetchSingleCategory = async () => {
    loading.value = true
    try {
       const res = await api.get(categoryAdmin.getCategory + router.params.id);
       categoryDetails.value = res?.category;
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
const getAllColor = async () => {
    try {
        const res = await api.get(colorAdmin.getColors);
        allColors.value = res?.colors;
    } catch (error) {
        console.log(error)
    }
}
onMounted(() => {
    fetchSingleCategory()
    getAllColor()
})



</script>