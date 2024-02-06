<template>
    <Layout>
        <PageTitle title="Order details" />
        <a-spin :spinning="loading">
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-lg font-semibold">#ORDER ID:
                            <span v-if="!loading" class="bg-white px-4 py-1 border border-gray-300 text-gray-500">{{
                                orderData?.result?.orderId
                            }}</span>
                        </h2>
                        <div class="flex items-center">
                            <h2 class="text-lg font-semibold uppercase">Order date:</h2>
                            <div class="ms-3">
                                <p class="text-gray-600 text-base">D: {{
                                    moment(orderData?.result?.createdAt).format('DD/MM/YYYY') }}</p>
                                <p class="text-gray-600 text-base"> T: {{ moment(orderData?.result?.createdAt).format('LT')
                                }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <AddressDetails v-if="!loading" :data="orderData?.result?.shippingAddress"
                            title="Shipping Details" />
                    </div>

                    <a-card v-if="orderData?.logistics" class="border border-gray-300">
                        <h2 class="text-lg font-semibold uppercase mb-5">Logistic Details:</h2>
                        <div>
                            <p class="text-base">Name: <span class="font-bold">REDX</span></p>
                            <div class="text-base">Tracking: <a href="https://www.facebook.com" target="_blank"
                                    class="text-blue-600">Click Here</a></div>
                        </div>
                    </a-card>
                </div>
                <div>
                    <Status :data="orderData?.result" :refetch="fetchOrderDetails" />
                    <AddressDetails v-if="!loading"
                        :data="{ ...orderData?.result?.billingAddress, ...orderData?.result?.payment }"
                        title="Billing Details" type="billing" />
                </div>
            </div>
            <div class="mb-5">
                <OrderItems v-if="Array.isArray(orderData?.result?.items) && !loading" :data="orderData?.result?.items" />
            </div>
        </a-spin>

    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router'
import { api, orderEndpoint } from '../../api';
import { Layout } from '../components/Layout';
import { AddressDetails, OrderItems, Status } from '../components/OrderDetails'
import { PageTitle } from '../components/shared';
import moment from 'moment';

const route = useRoute()
const orderData = ref({})
const loading = ref(false)
const fetchOrderDetails = async () => {
    loading.value = true
    try {
        orderData.value = await api.get(orderEndpoint.getOrders + route.params.id)
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(() => {
    fetchOrderDetails();
})

</script>