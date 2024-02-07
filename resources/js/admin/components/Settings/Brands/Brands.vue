<template>
    <div class="my-5">
        <CreateBrand :refetch="getAllbrands" />
    </div>
    <a-spin :spinning="loading">
        <div class="grid grid-cols-4 gap-5">
            <BrandItem v-for="brand of allBrands.data" :key="brand.id" :data="brand" :refetch="getAllbrands" />
        </div>
    </a-spin>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import CreateBrand from './CreateBrand.vue';
import BrandItem from './BrandItem.vue';
import { api, brandAdmin } from '../../../../api';

const allBrands = ref('');
const loading = ref(false);


const getAllbrands = async () => {
    loading.value = true;
    const res = await api.get(brandAdmin.getBrands);
    allBrands.value = res?.brands;
    loading.value = false
}

onMounted(() => {
    getAllbrands();
})

</script>