<template>
    <Layout>
        <PageTitle title="Order details" />
        <a-spin :spinning="loading">
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <div class="flex justify-between items-center mb-5">
                        <h2 class="text-lg font-semibold">#ORDER ID:
                            <span v-if="!loading" class="bg-white px-4 py-1 border border-gray-300 text-gray-500">{{
                                orderData?.order?.orderId
                            }}</span>
                        </h2>
                        <div class="flex items-center">
                            <h2 class="text-lg font-semibold uppercase">Order date:</h2>
                            <div class="ms-3">
                                <p class="text-gray-600 text-base">D: {{
                                    moment(orderData?.order?.createdAt).format('DD/MM/YYYY') }}</p>
                                <p class="text-gray-600 text-base"> T: {{ moment(orderData?.order?.createdAt).format('LT')
                                }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <AddressDetails v-if="!loading" :data="orderData?.order?.shippingAddress"
                            title="Shipping Details" />
                    </div>

                    <a-card v-if="orderData?.order?.logistics" class="border border-gray-300">
                        <h2 class="text-lg font-semibold uppercase mb-5">Logistic Details:</h2>
                        <div>
                            <p class="text-base">Name: <span class="font-bold">{{ orderData?.order?.logistics?.provider }}</span></p>
                            <div class="text-base">Tracking: <a :href="orderData?.order?.logistics?.trackingUrl" target="_blank"
                                    class="text-blue-600">Click Here</a></div>
                        </div>
                    </a-card>
                </div>
                <div>
                    <Status :data="orderData?.order" :refetch="fetchOrderDetails" />
                    <AddressDetails v-if="!loading"
                        :data="{ ...orderData?.order?.billingAddress, ...orderData?.order?.payment }"
                        title="Billing Details" type="billing" />
                </div>
            </div>
            <div class="mb-5">
                <OrderItems v-if="Array.isArray(orderData?.order?.items) && !loading" :data="orderData?.order?.items" />
            </div>
        </a-spin>

    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router'
import { api } from '../../api';
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
        orderData.value = await api.get('/admin/order/' + route.params.id)
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

onMounted(() => {
    fetchOrderDetails();
})

</script>