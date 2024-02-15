<template>
    <Layout>
        <div class="flex justify-center flex-wrap p-5 border-2 mb-5">
            <RouterLink v-for="brand of allBrands" :to="'/brands/' + brand?.id" :key="brand?.id">
                <span
                    :class="'font-semibold uppercase mx-5 bg-gray-100 px-5 py-2 hover:bg-theme-color hover:text-white ' + (route.params.id === brand?._id ? 'bg-theme-color text-white px-5 py-2' : '')">{{
                        brand?.name }}</span>
            </RouterLink>

        </div>
        <div v-if="allBrandProduct?.length">
            <a-spin :spinning="loading && allBrandProduct?.length">
                <ProductList :data=" allBrandProduct" />
            </a-spin>
        </div>
    </Layout>
</template>


<script setup>

import { Layout } from '../components/Layout';
import { onMounted, ref, watch } from 'vue';
import { ProductList } from '../components/CategoryDetails';
import { api, landingEndpoint, productEndpoint } from '../../api';
import { useRoute } from 'vue-router';
const allBrandProduct = ref([]);
const allBrands = ref([]);
const loading = ref(false);
const filters = ref({
    maxPrice: 10000,
    brands: []
})

const route = useRoute()
watch(() => route.params.id, () => {
    getProductOnBrand();
});
const getProductOnBrand = async () => {
    loading.value = true
    try {
        const res = await api.get(productEndpoint.fetchProductOnBrand + route.params.id, { filters: filters.value })
        allBrandProduct.value = res?.product || [];
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
const getAllBrands = async () => {
    try {
        const res = await api.get(landingEndpoint.getAllbrands)
        allBrands.value = res?.brands?.data || [];
    } catch (error) {
        console.log(error)
    }
}
onMounted(() => {
    getProductOnBrand();
    getAllBrands();
})

const onChangePrice = (value) => {
    filters.value.maxPrice = value;
    getProductOnBrand();
}

</script>