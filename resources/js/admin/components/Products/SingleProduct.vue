<template>
    <div class="hover:shadow-lg border-2 w-full p-5 relative">
        <img :src="JSON.parse(product?.colors[0].pivot?.images)[0] || '/assets/logo.png'"
            class="mb-5 w-full h-[250px] object-cover" />
        <div>
            <h6 class="text-lg mb-2">{{ product?.name }}</h6>
            <p class="font-semibold mb-2">Price: <span class="text-gray-500">USD {{ product?.discountAvailable ?
                product.discountPrice : product?.price }}</span> <span v-if="product?.discountAvailable"><s
                        class="text-gray-600">{{
                            product?.price }}</s></span></p>
            <div class="grid grid-cols-2 gap-5">
                <a-popconfirm @confirm="handleDelete" title="Are you sure?" ok-type="danger">
                    <EShopButton btn-text="DELETE" classes="bg-red-600 hover:bg-red-700"
                        icon-class="fa-solid fa-trash-can text-white" :onclick="() => { }" />
                </a-popconfirm>

                <EditProduct :refetch="refetch" :productDetails="product" :allColors="allColors" :allBrands="allBrands"
                    :allCategories="allCategories" />
            </div>
        </div>
        <div v-if="product?.newArrival" class="absolute top-[-6px] left-[-7px]">
            <img class="w-[68px]" :src="'/assets/tag1.png'" />
        </div>
    </div>
</template>


<script setup>
import { api, productAdmin } from '../../../api';
import { notify } from '../../../helpers';
import { EShopButton } from '../shared';
import { toRefs } from 'vue';
import EditProduct from './EditProduct.vue';

const props = defineProps({
    product: Object,
    refetch: Function,
    allColors: Array,
    allBrands: Array,
    allCategories: Array
})

const { refetch, product } = toRefs(props)

const handleDelete = async () => {
    try {
        const res = await api.delete(productAdmin.getProdcuts, product.value.id);
        notify(res, refetch.value)
    } catch (error) {
        console.log(error)
    }
}

</script>