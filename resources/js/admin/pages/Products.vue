<template>
    <Layout>
        <PageTitle title="Product" />
        <div class="text-xl my-5">Filter By:</div>
        <div class="flex justify-between mb-5">
            <div>
                <div class="mb-2 font-bold"><label>Category</label></div>
                <div>
                    <a-select v-model="filters.category" @change="handleSelectCategory" placeholder="Select category"
                        class="w-[300px] rounded-lg" size="large">
                        <a-select-option value="">All</a-select-option>
                        <a-select-option v-for="category of allCategories" :key="category.id" :value="category.id">{{
                            category.name
                        }}</a-select-option>
                    </a-select>
                </div>
            </div>
            <div class="my-5">
                <CreateProduct :refetch="getProducts" :allCategories="allCategories" :allColors="allColors"
                    :allBrands="allBrands" />
            </div>
        </div>
        <ProductTable :allProducts="allProducts" :loading="loading" :allBrands="allBrands" :allCategories="allCategories"
            :allColors="allColors" :refetch="getProducts" />
        <div class="text-right mt-5">
            <a-pagination :total="totalCount" :current="current" :page-size="15" @change="(page) => getProducts(page)" />
        </div>


    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { api } from '../../api';
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { CreateProduct, ProductTable } from '../components/Products';

const allProducts = ref([]);
const allColors = ref([]);
const allBrands = ref([]);
const allCategories = ref([]);
const loading = ref(false);
const filters = ref({
    category: ''
});

const totalCount = ref(0);
const current = ref(1);

const getProducts = async (page = 1) => {
    console.log(page)
    loading.value = true;
    try {
        const res = await api.get('admin/product', { ...filters.value, page });
        allProducts.value = res?.product.data;
        totalCount.value = res?.product.total;
        current.value = page;
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

const getColors = async () => {
    try {

        const res = await api.get('admin/color');
        allColors.value = res?.colors?.data;

    } catch (error) {
        console.log(error.message)
    }
}

const getCategories = async () => {
    try {
        const res = await api.get('admin/category');
        allCategories.value = res?.categories;
    } catch (error) {
        console.log(error.message)
    }
}

const getBrands = async () => {
    try {
        const res = await api.get('admin/brand');
        allBrands.value = res?.brands?.data;
    } catch (error) {
        console.log(error.message)
    }
}


const handleSelectCategory = (id) => {
    filters.value.category = id;
    getProducts();
}

onMounted(() => {
    getProducts();
    getColors();
    getCategories();
    getBrands();
});



</script>