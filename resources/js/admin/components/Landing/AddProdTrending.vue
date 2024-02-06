<template>
    <EShopButton icon-class="fa-solid fa-plus" btn-text="Add Products" classes="mb-5" :onclick="handleModal" />
    <a-modal v-model:open="open" width="1000px" title="Basic Modal" @ok="handleOk">
        <div class="grid grid-cols-4 gap-5">
            <a-card hoverable v-for="product of allProducts.result" :key="product._id" class="relative"
                @click="() => handleSelectProduct(product?._id)">
                <template #cover>
                    <img alt="example" class="h-[200px]" :src="product?.colors[0]?.images[0] ||'https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png'" />
                </template>
                <a-card-meta :title="product?.name" :description="'Category: ' + product?.category?.name" />
                <div v-if="selectedProduct.includes(product?._id)"
                    class="absolute top-3 right-3 bg-white rounded-full px-2 py-1"> <i
                        class="fa-solid fa-check text-green-500"></i></div>
            </a-card>
        </div>

    </a-modal>
</template>

<script setup>

import { ref, toRefs } from 'vue';
import { EShopButton } from '../shared';
import { api, landingAdmin, productAdmin } from '../../../api';
import { notify } from '../../../helpers';

const props = defineProps({
    data: Array,
    refetch: Function
})

const {data, refetch} = toRefs(props)

const open = ref(false);
const allProducts = ref([]);
const selectedProduct = ref(data?.value?.map(pr=>pr?._id));
const handleModal = async () => {
    open.value = true;
    try {
        allProducts.value = await api.get(productAdmin.getProdcuts)
    } catch (error) {
        console.log(error)
    }
}

const handleOk = async()=>{
    try {
        const res = await api.post(landingAdmin.updateTrending, { trendings: selectedProduct.value });
        notify(res, refetch.value)
        open.value = false
    } catch (error) {
        console.log(error)
    }
}

const handleSelectProduct = (id) => {
    const allSelectProd = selectedProduct.value;
    const searchIndex = allSelectProd.indexOf(id);
    if(searchIndex<0){
        allSelectProd.push(id);
    } else {
        allSelectProd.splice(searchIndex, 1);
    }
    selectedProduct.value = allSelectProd;
}

</script>