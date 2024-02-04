<template>
    <div class="my-5">
        <CreateBrand :refetch="getAllbrands" />
    </div>
    <a-spin :spinning="loading">
        <div class="grid grid-cols-4 gap-5">
            <BrandItem v-for="brand of allBrands.result" :key="brand._id" :data="brand" :refetch="getAllbrands" />
        </div>
    </a-spin>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import CreateBrand from './CreateBrand.vue';
import BrandItem from './BrandItem.vue';
import { api, brand } from '../../../api';

const allBrands = ref('');
const loading = ref(false);


const getAllbrands = async () => {
    loading.value = true;
    allBrands.value = await api.get(brand.getBrands);
    loading.value = false
}

onMounted(() => {
    getAllbrands();
})

</script>