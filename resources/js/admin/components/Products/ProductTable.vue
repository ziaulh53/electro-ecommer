<template>
    <a-table :columns="columns" :dataSource="allProducts" :loading="loading" :pagination="false">
        <template #bodyCell="{ column, record, index }">
            <template v-if="column.key === 'serial'">
                <p>{{ index + 1 }}</p>
            </template>
            <template v-if="column.key === 'image'">
                <img :src="JSON.parse(record?.default_images)[0]" class="w-[80px] h-[50px]" />
            </template>
            <template v-if="column.key === 'name'">
                <p>{{ record?.name }}</p>
            </template>
            <template v-if="column.key === 'category'">
                <p>{{ record?.category?.name }}</p>
            </template>
            <template v-if="column.key === 'price'">
                <p>{{ record?.price }}</p>
            </template>
            <template v-if="column.key === 'action'">
                <button class="text-blue-500 font-semibold underline" @click="() => handleOpenModal(record)">Edit</button>
            </template>
        </template>
    </a-table>
    <EditProduct v-if="productData?.id" :refetch="refetch" :handleCloseModal="handleCloseModal" v-bind:is-open-modal="isOpenModal"
        :productDetails="productData" :allColors="allColors" :allBrands="allBrands" :allCategories="allCategories" />
</template>

<script setup>
import { toRefs, ref } from 'vue'
import EditProduct from './EditProduct.vue';

const props = defineProps({
    allProducts: Array,
    loading: Boolean,
    allBrands: Array,
    allColors: Array,
    allCategories: Array,
    refetch: Function,
})

const { allProducts, loading } = toRefs(props);
const isOpenModal = ref(false);
const productData = ref({});


const handleOpenModal = (product) => {
    productData.value = {...product};
    isOpenModal.value = true;
}

const handleCloseModal = () => {
    productData.value = {};
    isOpenModal.value = false;
}

const columns = [
    {
        title: '#',
        key: 'serial'
    },
    {
        title: 'Image',
        key: 'image'
    },
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name'
    },
    {
        title: 'Catgory',
        key: 'category'
    },
    {
        title: 'Price',
        key: 'price'
    },
    {
        title: 'Action',
        key: 'action'
    },
];
</script>