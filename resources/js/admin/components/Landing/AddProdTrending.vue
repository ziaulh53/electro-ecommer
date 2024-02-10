<template>
    <EShopButton icon-class="fa-solid fa-plus" btn-text="Add Products" classes="mb-5" :onclick="handleModal" />
    <a-modal v-model:open="open" width="1000px" title="Basic Modal" @ok="handleOk">
        <a-spin :spinning="updateLoading">
            <div class="grid grid-cols-4 gap-5">
                <a-card hoverable v-for="product of allProducts" :key="product.id" class="relative"
                    @click="() => handleSelectProduct(product?.id)">
                    <template #cover>
                        <img alt="example" class="h-[200px]"
                            :src="JSON.parse(product?.colors[0]?.pivot?.images)[0] || 'https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png'" />
                    </template>
                    <a-card-meta :title="product?.name" :description="'Category: ' + product?.category?.name" />
                    <div v-if="selectedProduct.includes(product?.id)"
                        class="absolute top-3 right-3 bg-white rounded-full px-2 py-1"> <i
                            class="fa-solid fa-check text-green-500"></i></div>
                </a-card>
            </div>
        </a-spin>
    </a-modal>
</template>

<script setup>

import { computed, ref, toRefs } from 'vue';
import { EShopButton } from '../shared';
import { api, productAdmin } from '../../../api';
import { notify } from '../../../helpers';

const props = defineProps({
    data: Array,
    refetch: Function
})

const { data, refetch } = toRefs(props)

const open = ref(false);
const updateLoading = ref(false);
const allProducts = ref([]);
const selectedProduct = computed(()=>data?.value?.map(({ product }) => product?.id));
const handleModal = async () => {
    open.value = true;
    try {
        const res = await api.get(productAdmin.getProdcuts);
        console.log(res)
        allProducts.value = res.product;
    } catch (error) {
        console.log(error)
    }
}

const handleOk = async () => {
    try {
        // const res = await api.post(landingAdmin.updateTrending, { product_id:selectedProduct.value });
        // notify(res, refetch.value)
        open.value = false
    } catch (error) {
        console.log(error)
    }
}

const handleSelectProduct = async (id) => {
    updateLoading.value = true;
    const searchProd = selectedProduct.value?.find((prodId) => prodId===id);
    if (searchProd) {
        const res = await api.delete('admin/trending/', searchProd);
        notify(res);
    } else {
        const res = await api.post('admin/trending', { product_id: id });
        notify(res);
    }
    refetch.value();
    updateLoading.value = false;
}

</script>