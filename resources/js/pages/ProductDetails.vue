<template>
    <Layout>
        <div class="my-10">
            <div class="grid md:grid-cols-7 gap-x-24 mb-14">
                <div class="md:col-span-3">
                    <ImageViewer v-if="!loading" :colors="product?.result?.colors" :selected-colors="selectedColors" />
                    <EShopSkeleton v-if="loading" height="400px" />
                    <EShopSkeleton v-if="loading" height="70px" class="mt-5" />
                </div>
                <div class="md:col-span-4">
                    <EShopSkeleton v-if="loading" height="400px" type="content" />
                    <EShopSkeleton v-if="loading" height="400px" type="content" />
                    <EShopSkeleton v-if="loading" height="400px" type="content" />
                    <ProductInfo v-if="!loading" :data="product?.result" :handleSelectColor="handleSelectColor"
                        :selected-colors="selectedColors" />
                    <div v-if="!loading" class="my-5">
                        <EShopButton :disabled="selectedColors?.quantity < 2" iconclass="fa-solid fa-bag-shopping"
                            classes="font-semibold mr-10" btn-text="ADD CART" :onclick="handleAddCart" />
                        <AddWish />
                    </div>

                    <div v-if="selectedColors?.quantity < 2">
                        <button class="px-8 py-2 bg-red-500 text-white">SOLD OUT</button>
                    </div>

                    <div class="mt-10">
                        <div class="mb-3 text-xl font-[600]"> Specifications:</div>
                        <div v-html="product?.result?.description"></div>
                    </div>
                </div>
            </div>
            <ExploreMore v-if="product?.result" :category-id="product?.result?.category?._id" />
        </div>
    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Layout } from '../components/Layout';
import { api, productEndpoint } from '../api';
import { useRoute } from 'vue-router';
import { useCartStore } from '../store'
import { ImageViewer, ProductInfo, AddWish, ExploreMore } from '../components/ProductDetails'

import { EShopButton, EShopSkeleton } from '../components/shared';

const cartStore = useCartStore()


const product = ref({});
const selectedColors = ref({})

const loading = ref(false);

const route = useRoute()

const getProductDetails = async () => {

    try {
        loading.value = true
        product.value = await api.get(productEndpoint.fetchSingleProduct + route.params.id);
        selectedColors.value = product.value.result?.colors[0];
        loading.value = false
    } catch (error) {
        console.log(error)
    }

}

onMounted(() => {
    getProductDetails()
})

const handleSelectColor = async (idx) => {
    selectedColors.value = product.value.result?.colors[idx];
}

//add cart
const handleAddCart = () => {
    const data = {
        ...product.value.result,
        colors: selectedColors.value,
        quantity: 1
    }
    cartStore.userAddCart(data)
}


</script>