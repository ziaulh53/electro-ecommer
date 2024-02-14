<template>
    <h2 class="font-bold text-2xl mb-5">Filter</h2>
    <div class="p-2 bg-white border rounded-md border-gray-300">
        <div class="mb-4">
            <h6 class="text-gray-500">Price</h6>
            <a-slider v-model:value="filters.maxPrice" @afterChange="onChangePrice" :max="10000" :step="500"/>
        </div>
        <div>
            <h6 class="text-gray-500 mb-2">Brands</h6>
            <div>
                <a-checkbox-group v-model:value="brandsState" @change="handleBrands" class="block">
                    <div v-for="brand of allBrands" :key="brand.id" class="mb-1">
                        <a-checkbox :value="brand.id">{{ brand?.name
                        }}</a-checkbox>
                    </div>

                </a-checkbox-group>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, toRefs, onMounted } from 'vue';
import { api } from '../../../api';
const props = defineProps({
    handleFilterSubmit: Function
})

const {handleFilterSubmit } = toRefs(props);

const filters = ref({
    maxPrice: 10000000,
    brands: []
})

const allBrands = ref([]);

const brandsState = ref([]);


const onChangePrice = (value)=>{
    filters.value.maxPrice= value
    handleFilterSubmit.value(filters.value)
}
const handleBrands = (value)=>{
    filters.value.brands= value
    handleFilterSubmit.value(filters.value)
}

const fetchAllbrands = async()=>{
    try {
        const res = await api.get('brands');
        allBrands.value = res?.brands?.data;
    } catch (error) {
        console.log(error);
    }
}

onMounted(()=>{
    fetchAllbrands();
});

</script>