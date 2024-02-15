<template>
    <div class="flex mb-5 flex-wrap">
        <div :class="'bg-black py-2 px-5 mr-3 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected ? '' : 'bg-opacity-50')"
            @click="() => getAllOrders('')">All
        </div>
        <div :class="'bg-[#faad14] py-2 px-5 mr-3 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected === 'Pending' ? 'bg-opacity-50' : '')"
            @click="() => getAllOrders('Pending')">
            Pending
        </div>
        <div :class="'bg-[#1677ff] py-2 px-5 mr-3 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected === 'Accepted' ? 'bg-opacity-50' : '')"
            @click="() => getAllOrders('Accepted')">
            Proccessing
        </div>
        <div :class="'bg-[#1d39c4] py-2 px-5 mr-3 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected === 'Shipped' ? 'bg-opacity-50' : '')"
            @click="() => getAllOrders('Shipped')">
            Shipped
        </div>
        <div :class="'bg-[#52c41a] py-2 px-5 mr-3 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected === 'Delivered' ? 'bg-opacity-50' : '')"
            @click="() => getAllOrders('Delivered')">
            Delivered
        </div>
        <div :class="'bg-[#cf1322] py-2 px-5 text-white rounded-lg cursor-pointer hover:bg-opacity-50 ' + (selected === 'Cancelled' ? 'bg-opacity-50' : '')"
            @click="() => getAllOrders('Cancelled')">
            Cancelled
        </div>

    </div>
    <div v-if="loading" class="grid grid-cols-3 gap-5">
        <EShopSkeleton v-for="(_, idx) of new Array(6).fill(null)" :key="idx" height="350px" />
    </div>
    <div v-if="!loading" class="grid grid-cols-3 gap-5">
        <router-link v-for="({ id, items, status, orderId }) of allOrders?.orders" :to="'/order-details/' + id"
            :key="id">
            <div class="border-2 rounded-lg bg-white">
                <img :src="items[0]?.images?.[0] || '/assets/poster.jpg'"
                    class="h-[250px] w-full object-cover rounded-t-md" />
                <div class="p-4">
                    <h6 class="text-base font-bold mb-3">{{ items[0]?.name }}</h6>
                    <div class="flex justify-between items-center">
                        <div class="text-base font-semibold">Status: <a-tag :color="getStatusColor(status)">{{ status
                        }}</a-tag></div>
                        <div class="text-base font-semibold">Order ID: {{ orderId }}</div>
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { api, orderEndpoint } from '../../../api'
import { EShopSkeleton } from '../shared';
import { getStatusColor } from '../../../helpers';

const allOrders = ref({});
const loading = ref(false);
const selected = ref('');

const getAllOrders = async (status) => {
    selected.value = status
    loading.value = true
    try {
        allOrders.value = await api.get(orderEndpoint.getOrders, { status })
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}
onMounted(() => {
    getAllOrders();
})
</script>